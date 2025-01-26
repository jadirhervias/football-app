<?php

namespace Src\Player\Application\Find;

use Src\Player\Domain\Player;
use Src\Player\Domain\PlayerNotExists;
use Src\Player\Domain\PlayersRepository;

class PlayerFinder
{
    public function __construct(
        private readonly PlayersRepository $repository,
    )
    {
    }

    public function __invoke(FindPlayerRequest $request): Player
    {
        $team = $this->repository->findByExternalId($request->id());

        if (is_null($team)) {
            throw new PlayerNotExists($request->id());
        }

        return $team;
    }
}
