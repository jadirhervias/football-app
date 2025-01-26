<?php

namespace Src\Team\Application\Find;

class FindTeamRequest
{
    public function __construct(
        private readonly string $id,
    )
    {
    }

    public function id(): string
    {
        return $this->id;
    }
}
