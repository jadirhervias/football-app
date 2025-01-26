<?php

namespace Src\Shared\Domain;

use DomainException;

abstract class DomainError extends DomainException
{
    public function __construct()
    {
        parent::__construct(
            $this->errorMessage(),
            $this->errorCode(),
        );
    }

    public function errorName(): string
    {
        return strtoupper(Utils::toSnakeCase(class_basename(static::class)));
    }

    abstract public function errorCode(): int;

    abstract public function errorMessage(): string;

    public function toArray(): array
    {
        return [
            'message' => $this->getMessage(),
            'code' => $this->errorCode(),
            'error' => $this->errorName()
        ];
    }
}
