<?php

namespace App\Enums;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Pluralizer;

enum Permissions: string
{
    case VIEW_COMPETITIONS = 'view_competitions';
    case VIEW_TEAMS = 'view_teams';
    case VIEW_PLAYERS = 'view_players';
    case VIEW_ROLES = 'view_roles';
    case VIEW_PERMISSIONS = 'view_permissions';
    case ADD_TEAMS = 'add_teams';
    case ADD_PLAYERS = 'add_players';
    case ASSIGN_PERMISSIONS = 'assign_permissions';

    public function label(): string
    {
        App::setLocale('es');
        $action = __("permissions.actions.{$this->action()}");
        $singleResource = Pluralizer::singular($this->resource());
        $resource = __("permissions.resources.$singleResource");
        return "$action $resource";
    }

    private function action(): string
    {
        return explode('_', $this->value)[0];
    }

    private function resource(): string
    {
        return explode('_', $this->value)[1];
    }

    public static function fromArray($values): array {
        return array_filter(
            array_map(
                fn($value) => Permissions::tryFrom($value),
                $values
            )
        );
    }
}

