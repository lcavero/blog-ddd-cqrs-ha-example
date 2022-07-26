<?php

namespace App\Post\Infrastructure\Controller\Api;

use App\Post\Application\Query\GetPostQuery;
use App\Shared\Infrastructure\Controller\Controller;
use App\Shared\Infrastructure\Exception\ResourceNotFoundHttpException;
use Lib\CQRS\QueryBus;
use Lib\Serializer\JsonSerializer;
use Lib\ValueObject\Exception\InvalidIdException;
use Lib\ValueObject\Id;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

class GetPostAction implements Controller
{
    public function __construct(private QueryBus $queryBus, private JsonSerializer $serializer)
    {}

    #[Route('/{id}', name: 'get_post', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Return a posts',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'id', type: 'string'),
                new OA\Property(property: 'title', type: 'string'),
                new OA\Property(property: 'body', type: 'string'),
                new OA\Property(property: 'author', type: 'object', properties: [
                    new OA\Property(property: 'id', type: 'string'),
                    new OA\Property(property: 'username', type: 'string'),
                    new OA\Property(property: 'email', type: 'string'),
                    new OA\Property(property: 'website', type: 'string'),
                ]),
            ]
        )
    )]
    public function __invoke(string $id, Request $request): JsonResponse
    {
        try {
            $result = $this->queryBus->handle(GetPostQuery::create(Id::fromString($id)));
        } catch (InvalidIdException $e) {
            throw ResourceNotFoundHttpException::fromMessage(sprintf('No post found with id %s', $id), $e);
        }

        return JsonResponse::fromJsonString($this->serializer->serialize($result, 'json'));
    }
}
