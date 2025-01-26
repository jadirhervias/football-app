<?php

namespace Src\User\Domain;

use App\Enums\Roles;
use Src\Shared\Domain\AggregateRoot;
use Src\Shared\Domain\EnhancedDateTime;

class User extends AggregateRoot
{
    public function __construct(
        private readonly string $id,
        private readonly string $name,
        private readonly string $email,
        private readonly array $roles,
        private readonly array $permissions,
        private readonly string $password,
        private readonly ?string $createdAt,
        private readonly ?string $updatedAt,
    )
    {
    }

    public static function create(
        string $id,
        string $name,
        string $email,
        Roles $role,
        string $password,
    ): User
    {
        $now = EnhancedDateTime::now()->format();
        return new self(
            $id,
            $name,
            $email,
            [$role],
            [],
            $password,
            $now,
            $now,
        );
    }

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function roles(): array
    {
        return $this->roles;
    }

    public function permissions(): array
    {
        return $this->permissions;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function toPrimitives(): array
    {
        return [
            'uuid' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'roles' => $this->roles,
            'permissions' => $this->permissions,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}
