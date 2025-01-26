<?php

namespace Src\User\Application\Find;

class FindUserRequest
{
    public function __construct(
        private readonly string $email,
    )
    {
    }

    public function email(): string
    {
        return $this->email;
    }
}
