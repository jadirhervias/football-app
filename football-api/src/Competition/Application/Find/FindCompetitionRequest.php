<?php

namespace Src\Competition\Application\Find;

class FindCompetitionRequest
{
    public function __construct(
        private readonly string $code,
    )
    {
    }

    public function code(): string
    {
        return $this->code;
    }
}
