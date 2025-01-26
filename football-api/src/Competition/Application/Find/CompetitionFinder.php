<?php

namespace Src\Competition\Application\Find;

use Src\Competition\Domain\Competition;
use Src\Competition\Domain\CompetitionNotExists;
use Src\Competition\Domain\CompetitionsRepository;

class CompetitionFinder
{
    public function __construct(
        private readonly CompetitionsRepository $repository,
    )
    {
    }

    public function __invoke(FindCompetitionRequest $request): Competition
    {
        $competition = $this->repository->findByExternalId($request->id());

        if (is_null($competition)) {
            throw new CompetitionNotExists($request->id());
        }

        return $competition;
    }
}
