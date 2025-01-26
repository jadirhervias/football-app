<?php

namespace Src\Shared\Infrastructure\FootballApi;

use Src\Shared\Domain\DomainError;

class FetchApiDataFailed extends DomainError
{
    public function __construct(private readonly string $errorDetails)
    {
        parent::__construct();
    }

    public function errorCode(): int
    {
        return 404;
    }

    public function errorMessage(): string
    {
        return $this->errorDetails;
    }
}
