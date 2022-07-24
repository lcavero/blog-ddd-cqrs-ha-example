<?php

namespace App\Tests\User\Domain\Mock;

use App\User\Domain\User;

class UserMother
{
    public static function one(): User
    {
        $userId = UserIdMother::random();
        return User::create($userId);
    }
}
