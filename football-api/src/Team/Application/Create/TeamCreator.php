<?php

namespace Src\Team\Application\Create;

use Src\Shared\Domain\Uuid;
use Src\Team\Domain\Team;
use Src\Team\Domain\TeamsRepository;

class TeamCreator
{
    public function __construct(
        private readonly TeamsRepository $repository,
    )
    {
    }

    public function __invoke(CreatTeamRequest $request): Team
    {
        $team = Team::create(array_merge(
            ['id' => Uuid::random()->value()],
            $request->toArray()
        ));

        $this->repository->save($team);

        return $team;
    }
}
