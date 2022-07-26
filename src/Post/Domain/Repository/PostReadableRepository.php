<?php

namespace App\Post\Domain\Repository;

use App\Post\Domain\Post;
use App\Post\Domain\PostId;

interface PostReadableRepository
{
    public function findAll(): array;
    public function findOne(PostId $postId): ?Post;
}
