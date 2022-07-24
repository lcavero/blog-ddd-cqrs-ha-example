<?php

namespace App\Post\Application\Query;

use Lib\CQRS\Query;

class GetPostsQuery implements Query
{
    private function __construct()
    {}

    public static function create(): self
    {
        return new static();
    }
}
