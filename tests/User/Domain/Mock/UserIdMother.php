<?php

namespace App\Tests\User\Domain\Mock;

use App\User\Domain\UserId;
use Lib\ValueObject\IdFactory;

class UserIdMother
{
    public static function random(): UserId
    {
        return UserId::fromId(IdFactory::create());
    }
}
