<?php

namespace Src\User\Domain;

use Src\Shared\Domain\DomainError;

class UserAlreadyExists extends DomainError
{
    public function __construct(private readonly string $email)
    {
        parent::__construct();
    }

    public function errorCode(): int
    {
        return 200;
    }

    public function errorMessage(): string
    {
        return sprintf('User with email <%s> already exists', $this->email);
    }
}
