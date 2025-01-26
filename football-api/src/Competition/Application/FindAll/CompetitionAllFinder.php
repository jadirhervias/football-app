<?php

namespace Src\Competition\Application\FindAll;

use Src\Competition\Domain\Competition;
use Src\Competition\Domain\CompetitionsRepository;
use Src\Competition\Infrastructure\FootballApi\FootballApiCompetitions;

class CompetitionAllFinder
{
    public function __construct(
        private readonly FootballApiCompetitions $competitionsApi,
//        private readonly CompetitionsRepository $repository,
    )
    {
    }

    /** @return array<Competition> */
    public function __invoke(FindAllCompetitionRequest $request): array
    {
        return $this->competitionsApi->getAll($request->limit(), $request->offset());
    }
}
