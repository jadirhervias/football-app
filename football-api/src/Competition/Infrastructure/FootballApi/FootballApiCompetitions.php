<?php

namespace Src\Competition\Infrastructure\FootballApi;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Src\Competition\Domain\Competition;
use Src\Shared\Domain\AggregateRoot;
use Src\Shared\Infrastructure\FootballApi\FetchApiDataFailed;
use Src\Shared\Infrastructure\FootballApi\FootballApi;
use Symfony\Component\HttpFoundation\Response;

class FootballApiCompetitions extends FootballApi
{
    public function resourceName(): string
    {
        return 'competitions';
    }

    public function responseSerializer(array $data): AggregateRoot
    {
        return Competition::create(array_merge(
            $data,
            [
                'external_id' => data_get($data, 'id'),
                'number_of_available_seasons' => data_get($data, 'numberOfAvailableSeasons'),
                'area_code' => data_get($data, 'area.code'),
                'area_flag' => data_get($data, 'area.flag'),
            ]
        ));
    }

    public function findByExternalId(string $externalId): ?Competition
    {
        return $this->fetchOneById($externalId);
    }

    /** @return array<Competition> */
    public function getAll(int $limit, int $offset): array
    {
        return $this->fetchAll($limit, $offset);
    }

    public function findByCode(string $competitionCode, array $parsers): ?array
    {
        try {
            $response = Http::withHeader('X-Auth-Token', env('FOOTBALL_API_TOKEN'))
                ->get("{$this->getResourceEndpoint()}/$competitionCode/teams");

            if ($response->status() === Response::HTTP_NOT_FOUND) {
                return null;
            }

            if ($response->failed()) {
                throw new FetchApiDataFailed($response->reason());
            }

            $allSquads = array_merge(...array_map(function ($team) {
                return $team['squad'];
            }, $response->json('teams')));

            $uniqueSquads = array_unique($allSquads, SORT_REGULAR);

            return [
                'competition' => $this->responseSerializer($response->json('competition')),
                'teams' => array_map(
                    fn($item) => $parsers['teams']($item),
                    $response->json('teams')
                ),
                'players' => array_map(
                    fn($item) => $parsers['players']($item),
                    $uniqueSquads
                ),
            ];
        } catch (ConnectionException $e) {
            throw new FetchApiDataFailed($e->getMessage());
        }
    }
}
