<?php

namespace Src\Competition\Application\FindAll;

class FindAllCompetitionRequest
{
    public function __construct(
        private readonly int $limit = 50,
        private readonly int $offset = 50,
    )
    {
    }

    public function limit(): int
    {
        return $this->limit;
    }

    public function offset(): int
    {
        return $this->offset;
    }
}
