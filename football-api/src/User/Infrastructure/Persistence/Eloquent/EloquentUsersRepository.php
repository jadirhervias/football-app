<?php

namespace Src\User\Infrastructure\Persistence\Eloquent;

use App\Enums\Permissions;
use App\Enums\Roles;
use App\Models\User as UserEloquentModel;
use Src\Shared\Domain\Utils;
use Src\User\Domain\User;
use Src\User\Domain\UsersRepository;
use Src\Shared\Domain\AggregateRoot;
use Src\Shared\Infrastructure\Persistence\Eloquent\EloquentRepository;

class EloquentUsersRepository extends EloquentRepository implements UsersRepository
{
    function serializer($attributes): AggregateRoot
    {
        return new User(
            $attributes['uuid'],
            $attributes['name'],
            $attributes['email'],
            Roles::fromArray($attributes['roles']),
            Permissions::fromArray($attributes['permissions']),
            $attributes['password'],
            $attributes['created_at'],
            $attributes['updated_at'],
        );
    }

    function modelClass(): string
    {
        return UserEloquentModel::class;
    }

    public function save(User $user): void
    {
        $model = $this->model()->fill(array_merge(
            Utils::omitKeys($user->toPrimitives(), ['roles', 'permissions']),
            ['password' => $user->password()]
        ));

        $savedUser = $this->model()::query()->updateOrCreate(
            [$model->getKeyName() => $model->getKey()],
            $model->makeVisible('password')->toArray()
        );

        $savedUser->assignRole($user->roles());
    }

    public function findByEmail(string $email): ?User
    {
        /** @var UserEloquentModel|null $user */
        $user = $this->builder()->firstWhere('email', $email);
        $userPrimitives = null;

        if ($user) {
            $user->makeVisible('password');

            $userPrimitives = array_merge(
                $user->toArray(),
                [
                    'roles' => $user->roles->pluck('name')->toArray(),
                    'permissions' => $user->roles->flatMap->permissions->pluck('name')->toArray(),
                ]
            );
        }

        return $userPrimitives ? $this->serializer($userPrimitives) : null;
    }
}
