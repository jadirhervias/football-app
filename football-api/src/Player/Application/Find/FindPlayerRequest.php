<?php

namespace Src\Player\Application\Find;

class FindPlayerRequest
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
