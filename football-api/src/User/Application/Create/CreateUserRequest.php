<?php

namespace Src\User\Application\Create;

use App\Enums\Roles;

class CreateUserRequest
{
    public function __construct(
        private readonly string $name,
        private readonly string $email,
        private readonly Roles $role,
        private readonly string $hashedPassword,
    )
    {
    }

    public function name(): string
    {
        return $this->name;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function role(): Roles
    {
        return $this->role;
    }

    public function hashedPassword(): string
    {
        return $this->hashedPassword;
    }
}
