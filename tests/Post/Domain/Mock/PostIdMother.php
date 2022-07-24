<?php

namespace App\Tests\Post\Domain\Mock;

use App\Post\Domain\PostId;
use Lib\ValueObject\IdFactory;

class PostIdMother
{
    public static function random(): PostId
    {
        return PostId::fromId(IdFactory::create());
    }
}
