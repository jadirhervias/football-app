<?php

namespace Src\Competition\Application\Find;

use Src\Competition\Domain\Competition;
use Src\Competition\Domain\CompetitionNotExists;
use Src\Competition\Domain\CompetitionsRepository;
use Src\Competition\Infrastructure\FootballApi\FootballApiCompetitions;
use Src\Player\Domain\PlayersRepository;
use Src\Player\Infrastructure\FootballApi\FootballApiPlayers;
use Src\Team\Domain\TeamsRepository;
use Src\Team\Infrastructure\FootballApi\FootballApiTeams;

class CompetitionFinder
{
    public function __construct(
        private readonly CompetitionsRepository $competitionsRepository,
        private readonly PlayersRepository $playersRepository,
        private readonly TeamsRepository $teamsRepository,
        private readonly FootballApiCompetitions $competitionsApi,
        private readonly FootballApiTeams $teamsApi,
        private readonly FootballApiPlayers $playersApi,
    )
    {
    }

    public function __invoke(FindCompetitionRequest $request): Competition
    {
        $competition = $this->competitionsRepository->findByExternalId($request->code());

        if (is_null($competition)) {
            $resources = $this->competitionsApi->findByCode(
                $request->code(),
                [
                    $this->teamsApi->resourceName() => fn($data) => $this->teamsApi->responseSerializer($data),
                    $this->playersApi->resourceName() => fn($data) => $this->playersApi->responseSerializer($data),
                ]
            );

            if (is_null($resources)) {
                throw new CompetitionNotExists($request->code());
            }

            $competition = $resources['competition'];
            $this->teamsRepository->insertMany($resources['teams']);
            $this->playersRepository->insertMany($resources['players']);
        }

        return $competition;
    }
}
