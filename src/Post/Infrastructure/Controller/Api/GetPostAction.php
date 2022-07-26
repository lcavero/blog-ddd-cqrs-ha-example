<?php

namespace App\Post\Infrastructure\Controller\Api;

use App\Post\Application\Query\GetPostQuery;
use App\Shared\Infrastructure\Controller\Controller;
use App\Shared\Infrastructure\Exception\ResourceNotFoundHttpException;
use Lib\CQRS\QueryBus;
use Lib\ValueObject\Exception\InvalidIdException;
use Lib\ValueObject\Id;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GetPostAction implements Controller
{
    public function __construct(private QueryBus $queryBus)
    {}

    #[Route('/{postId}', name: 'get_post', methods: ['GET'])]
    public function __invoke(string $postId, Request $request): JsonResponse
    {
        try {
            $result = $this->queryBus->handle(GetPostQuery::create(Id::fromString($postId)));
        } catch (InvalidIdException $e) {
            throw ResourceNotFoundHttpException::fromMessage(sprintf('No post found with id %s', $postId), $e);
        }

        return new JsonResponse($result);
    }
}
