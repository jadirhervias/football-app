<?php

namespace Src\User\Application\Find;

use Src\User\Domain\User;
use Src\User\Domain\UserNotExists;
use Src\User\Domain\UsersRepository;

class UserFinder
{
    public function __construct(
        private readonly UsersRepository $repository,
    )
    {
    }

    public function __invoke(FindUserRequest $request): User
    {
        $user = $this->repository->findByEmail($request->email());

        if (is_null($user)) {
            throw new UserNotExists($request->email());
        }

        return $user;
    }
}
