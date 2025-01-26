<?php

namespace Src\Competition\Infrastructure\FootballApi;

use Src\Competition\Domain\Competition;
use Src\Competition\Domain\CompetitionsRepository;
use Src\Shared\Domain\AggregateRoot;
use Src\Shared\Infrastructure\FootballApi\FootballApi;

class FootballApiCompetitions extends FootballApi implements CompetitionsRepository
{
    protected function resourceName(): string
    {
        return 'competitions';
    }

    protected function responseSerializer(array $data): AggregateRoot
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
}
