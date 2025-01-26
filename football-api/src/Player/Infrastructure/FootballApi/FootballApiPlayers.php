<?php

namespace Src\Player\Infrastructure\FootballApi;

use Src\Player\Domain\Player;
use Src\Shared\Infrastructure\FootballApi\FootballApi;

class FootballApiPlayers extends FootballApi
{
    public function resourceName(): string
    {
        return 'players';
    }

    public function responseSerializer(array $data): Player
    {
        return Player::create(array_merge(
            $data,
            [
                'external_id' => data_get($data, 'id'),
                'shirt_number' => data_get($data, 'shirtNumber'),
                'date_of_birth' => data_get($data, 'dateOfBirth'),
            ]
        ));
    }
}
