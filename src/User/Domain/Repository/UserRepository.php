<?php

namespace App\User\Domain\Repository;

use App\User\Domain\User;

interface UserRepository extends UserReadableRepository
{
    public function create(User $user): void;
    public function update(User $user): void;
}
