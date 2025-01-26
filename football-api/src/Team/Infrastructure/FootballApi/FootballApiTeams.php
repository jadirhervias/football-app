<?php

namespace Src\Team\Infrastructure\FootballApi;

use Src\Team\Domain\Team;
use Src\Shared\Infrastructure\FootballApi\FootballApi;

class FootballApiTeams extends FootballApi
{
    public function resourceName(): string
    {
        return 'teams';
    }

    public function responseSerializer(array $data): Team
    {
        return Team::create(array_merge(
            $data,
            [
                'external_id' => data_get($data, 'id'),
                'short_name' => data_get($data, 'shortName'),
                'coach_name' => data_get($data, 'coach.name'),
                'coach_nationality' => data_get($data, 'coach.nationality'),
            ]
        ));
    }
}
