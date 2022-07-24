<?php

namespace App\Post\Application\Query;

use App\Post\Domain\Service\PostFinderService;
use Lib\CQRS\QueryHandler;

class GetPostQueryHandler implements QueryHandler
{
    public function __construct(private PostFinderService $finderService)
    {}

    public function __invoke(GetPostQuery $query): GetPostQueryResponse
    {
        return GetPostQueryResponse::fromEntity(
            $this->finderService->findOrFail($query->postId())
        );
    }
}
