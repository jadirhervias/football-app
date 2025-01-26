<?php

namespace Src\Competition\Domain;

use Src\Shared\Domain\DomainError;

class CompetitionNotExists extends DomainError
{
    public function __construct(private readonly string $id)
    {
        parent::__construct();
    }

    public function errorCode(): int
    {
        return 404;
    }

    public function errorMessage(): string
    {
        return sprintf('Competition with id <%s> not exists', $this->id);
    }
}
