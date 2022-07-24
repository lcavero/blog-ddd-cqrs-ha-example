<?php

namespace App\Post\Domain\Repository;

use App\Post\Domain\Post;
use App\Post\Domain\PostId;

interface PostRepository
{
    public function findAll(): array;
    public function findOne(PostId $postId): ?Post;
    public function create(Post $post): void;
    public function update(Post $post): void;
}
