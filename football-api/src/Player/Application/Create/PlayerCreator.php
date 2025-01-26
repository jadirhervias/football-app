<?php

namespace Src\Player\Application\Create;

use Src\Shared\Domain\Uuid;
use Src\Player\Domain\Player;
use Src\Player\Domain\PlayersRepository;

class PlayerCreator
{
    public function __construct(
        private readonly PlayersRepository $repository,
    )
    {
    }

    public function __invoke(CreatePlayerRequest $request): Player
    {
        $player = Player::create(array_merge(
            ['id' => Uuid::random()->value()],
            $request->toArray()
        ));

        $this->repository->save($player);

        return $player;
    }
}
