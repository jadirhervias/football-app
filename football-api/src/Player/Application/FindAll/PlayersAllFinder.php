<?php

namespace Src\Player\Application\FindAll;

use Src\Player\Domain\Player;
use Src\Player\Domain\PlayersRepository;

class PlayersAllFinder
{
    public function __construct(
        private readonly PlayersRepository $repository,
    )
    {
    }

    /** @return array<Player> */
    public function __invoke(FindAllPlayersRequest $request): array
    {
        return $this->repository->getAll($request->limit(), $request->offset());
    }
}
