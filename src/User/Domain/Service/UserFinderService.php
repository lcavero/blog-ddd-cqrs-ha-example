<?php

namespace App\User\Domain\Service;

use App\User\Domain\Exception\UserNotFoundException;
use App\User\Domain\Repository\UserReadableRepository;
use App\User\Domain\User;
use App\User\Domain\UserId;

class UserFinderService
{
    public function __construct(private UserReadableRepository $repository)
    {}

    public function find(UserId $userId): ?User
    {
        return $this->repository->findOne($userId);
    }

    public function findOrFail(UserId $userId): User
    {
        $user = $this->repository->findOne($userId);

        if (!$user) {
            throw UserNotFoundException::fromUserId($userId);
        }

        return $user;
    }
}
