<?php

namespace App\Post\Infrastructure\Controller\Api;

use App\Post\Application\Query\GetPostsQuery;
use App\Shared\Infrastructure\Controller\Controller;
use Lib\CQRS\QueryBus;
use Lib\Serializer\JsonSerializer;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ListPostAction implements Controller
{
    public function __construct(private QueryBus $queryBus, private JsonSerializer $serializer)
    {}

    #[Route('/', name: 'list_posts', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Return a list of posts',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(type: 'object', properties: [
                new OA\Property(property: 'id', type: 'string'),
                new OA\Property(property: 'title', type: 'string'),
                new OA\Property(property: 'author', type: 'object', properties: [
                    new OA\Property(property: 'id', type: 'string'),
                    new OA\Property(property: 'username', type: 'string'),
                    new OA\Property(property: 'email', type: 'string'),
                    new OA\Property(property: 'website', type: 'string'),
                ]),
            ])
        )
    )]
    public function __invoke(Request $request): JsonResponse
    {
        $result = $this->queryBus->handle(GetPostsQuery::create());
        return JsonResponse::fromJsonString($this->serializer->serialize($result, 'json'));
    }
}
