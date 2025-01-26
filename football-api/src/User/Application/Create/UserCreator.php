<?php

namespace Src\User\Application\Create;

use Src\Shared\Domain\Uuid;
use Src\User\Domain\User;
use Src\User\Domain\UserAlreadyExists;
use Src\User\Domain\UsersRepository;

class UserCreator
{
    public function __construct(
        private readonly UsersRepository $repository,
    )
    {
    }

    public function __invoke(CreateUserRequest $request): User
    {
        $foundUser = $this->repository->findByEmail($request->email());

        if (!is_null($foundUser)) {
            throw new UserAlreadyExists($request->email());
        }

        $user = User::create(
            Uuid::random()->value(),
            $request->name(),
            $request->email(),
            $request->role(),
            $request->hashedPassword()
        );

        $this->repository->save($user);

        return $user;
    }
}
