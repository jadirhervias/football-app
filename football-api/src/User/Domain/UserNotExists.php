<?php

namespace Src\User\Domain;

use Src\Shared\Domain\DomainError;

class UserNotExists extends DomainError
{
    public function __construct(private readonly string $email)
    {
        parent::__construct();
    }

    public function errorCode(): int
    {
        return 404;
    }

    public function errorMessage(): string
    {
        return sprintf('User with email <%s> not exists', $this->email);
    }
}
