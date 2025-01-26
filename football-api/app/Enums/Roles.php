<?php

namespace App\Enums;

enum Roles: string
{
    case SUPER_ADMIN = 'super_admin';
    case ADMIN = 'admin';
    case GUEST = 'guest';

    public function label(): string
    {
        return __("roles.$this->value");
    }

    public function defaultPermissions(): array
    {
        return match ($this) {
            Roles::SUPER_ADMIN => Permissions::cases(),
            Roles::ADMIN => [
                Permissions::ADD_PLAYERS,
                Permissions::ADD_TEAMS,
                Permissions::VIEW_COMPETITIONS,
                Permissions::VIEW_TEAMS,
                Permissions::VIEW_PLAYERS,
                Permissions::VIEW_ROLES,
                Permissions::VIEW_PERMISSIONS,
            ],
            Roles::GUEST => [
                Permissions::VIEW_COMPETITIONS,
                Permissions::VIEW_TEAMS,
                Permissions::VIEW_PLAYERS,
            ],
        };
    }

    public static function fromArray($values): array {
         return array_filter(
            array_map(
                fn($value) => Roles::tryFrom($value),
                $values
            )
        );
    }
}
