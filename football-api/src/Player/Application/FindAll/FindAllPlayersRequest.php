<?php

namespace Src\Player\Application\FindAll;

class FindAllPlayersRequest
{
    public function __construct(
        private readonly int $limit = 25,
        private readonly int $offset = 0,
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
