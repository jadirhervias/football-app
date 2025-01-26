<?php

namespace Src\Team\Application\Find;

use Src\Team\Domain\Team;
use Src\Team\Domain\TeamNotExists;
use Src\Team\Domain\TeamsRepository;

class TeamFinder
{
    public function __construct(
        private readonly TeamsRepository $repository,
    )
    {
    }

    public function __invoke(FindTeamRequest $request): Team
    {
        $team = $this->repository->findByExternalId($request->id());

        if (is_null($team)) {
            throw new TeamNotExists($request->id());
        }

        return $team;
    }
}
