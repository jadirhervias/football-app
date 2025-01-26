<?php

namespace App\Providers;

use App\Enums\Roles;
use Src\Competition\Domain\CompetitionsRepository;
use Src\Competition\Infrastructure\FootballApi\FootballApiCompetitions;
use Src\Competition\Infrastructure\Persistence\Eloquent\EloquentCompetitionsRepository;
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
        $this->app->bind(CompetitionsRepository::class, FootballApiCompetitions::class);
//        $this->app->bind(CompetitionsRepository::class, EloquentCompetitionsRepository::class);

        Gate::before(function ($user, $ability) {
            return $user->hasRole(Roles::SUPER_ADMIN) ? true : null;
        });
    }
}
