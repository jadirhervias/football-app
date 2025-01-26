<?php

namespace Src\Team\Domain;

use Src\Shared\Domain\DomainError;

class TeamNotExists extends DomainError
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
        return sprintf('Team with ID <%s> not exists', $this->id);
    }
}
