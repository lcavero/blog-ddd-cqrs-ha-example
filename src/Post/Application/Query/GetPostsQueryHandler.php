<?php

namespace App\Post\Application\Query;

use App\Post\Domain\Post;
use App\Post\Domain\Repository\PostReadableRepository;
use Lib\CQRS\QueryHandler;

class GetPostsQueryHandler implements QueryHandler
{
    public function __construct(private PostReadableRepository $repository)
    {}

    public function __invoke(GetPostsQuery $query): array
    {
        $posts = $this->repository->findAll();
        return array_map(fn(Post $post) => GetPostsQueryResponse::fromEntity($post), $posts);
    }
}
