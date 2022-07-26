<?php

namespace App\Tests\User\Domain\Mock;

use App\User\Domain\User;

class UserMother
{
    public static function one(): User
    {
        $userId = UserIdMother::random();
        return User::register(
            $userId,
            'testuser',
            '12345',
            'testuser@test.com',
            '666886688',
            'https://testuser.com'
        );
    }
}
