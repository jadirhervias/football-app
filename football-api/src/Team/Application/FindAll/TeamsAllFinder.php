<?php

namespace Src\Team\Application\FindAll;

use Src\Team\Domain\Team;
use Src\Team\Domain\TeamsRepository;

class TeamsAllFinder
{
    public function __construct(
        private readonly TeamsRepository $repository,
    )
    {
    }

    /** @return array<Team> */
    public function __invoke(FindAllTeamsRequest $request): array
    {
        return $this->repository->getAll($request->limit(), $request->offset());
    }
}
