<?php

namespace App\Post\Domain\Repository;

use App\Post\Domain\Post;

interface PostRepository extends PostReadableRepository
{
    public function create(Post $post): void;
    public function update(Post $post): void;
}
