<?php

namespace Src\Competition\Application\Find;

class FindCompetitionRequest
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
