<?php

namespace App\Providers;

use App\Enums\Roles;
use Src\Competition\Domain\CompetitionsRepository;
use Src\Competition\Infrastructure\Persistence\Eloquent\EloquentCompetitionsRepository;
use Src\Player\Domain\PlayersRepository;
use Src\Player\Infrastructure\Persistence\Eloquent\EloquentPlayersRepository;
use Src\Team\Domain\TeamsRepository;
use Src\Team\Infrastructure\Persistence\Eloquent\EloquentTeamsRepository;
use Src\User\Domain\UsersRepository;
use Src\User\Infrastructure\Persistence\Eloquent\EloquentUsersRepository;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(UsersRepository::class, EloquentUsersRepository::class);
        $this->app->bind(CompetitionsRepository::class, EloquentCompetitionsRepository::class);
        $this->app->bind(TeamsRepository::class, EloquentTeamsRepository::class);
        $this->app->bind(PlayersRepository::class, EloquentPlayersRepository::class);

        Gate::before(function ($user, $ability) {
            return $user->hasRole(Roles::SUPER_ADMIN) ? true : null;
        });
    }
}
