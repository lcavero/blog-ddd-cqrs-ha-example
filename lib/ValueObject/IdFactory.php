<?php

namespace Lib\ValueObject;

use Symfony\Component\Uid\Uuid;

class IdFactory
{
    public static function create(): Id
    {
        return Id::fromString(Uuid::v4());
    }
}
