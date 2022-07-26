<?php

namespace App\Post\Domain\Service;

use App\Post\Domain\Exception\PostNotFoundException;
use App\Post\Domain\Post;
use App\Post\Domain\PostId;
use App\Post\Domain\Repository\PostReadableRepository;

class PostFinderService
{
    public function __construct(private PostReadableRepository $repository)
    {}

    public function find(PostId $postId): ?Post
    {
        return $this->repository->findOne($postId);
    }

    public function findOrFail(PostId $postId): Post
    {
        $post = $this->repository->findOne($postId);

        if (!$post) {
            throw PostNotFoundException::fromPostId($postId);
        }

        return $post;
    }
}
