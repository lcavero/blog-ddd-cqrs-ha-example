<?php

namespace App\Post\Infrastructure\Controller\Api;

use App\Post\Application\Query\GetPostsQuery;
use App\Shared\Infrastructure\Controller\Controller;
use Lib\CQRS\QueryBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ListPostAction implements Controller
{
    public function __construct(private QueryBus $queryBus)
    {}

    #[Route('/', name: 'list_posts', methods: ['GET'])]
    public function __invoke(Request $request): JsonResponse
    {
        $result = $this->queryBus->handle(GetPostsQuery::create());
        return new JsonResponse($result);
    }
}
