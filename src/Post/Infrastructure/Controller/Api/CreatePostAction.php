<?php

namespace App\Post\Infrastructure\Controller\Api;

use App\Post\Application\Command\CreatePostCommand;
use App\Shared\Infrastructure\Controller\Controller;
use App\Shared\Infrastructure\Exception\BadRequestHttpException;
use App\Shared\Infrastructure\Exception\UnauthorizedHttpException;
use Lib\CQRS\CommandBus;
use Lib\Security\Identifiable;
use Lib\Validation\Exception\ValidationExceptionInterface;
use Lib\ValueObject\IdFactory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use OpenApi\Attributes as OA;

class CreatePostAction implements Controller
{
    public function __construct(private CommandBus $commandBus)
    {}

    #[Route('/', name: 'create_post', methods: ['POST'])]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(type: 'object', properties: [
            new OA\Property(property: 'title',  type: 'string'),
            new OA\Property(property: 'body',  type: 'string'),
        ])
    )]
    #[OA\Response(
        response: 201,
        description: 'Create a post',
        content: new OA\JsonContent(type: 'object', properties: [
            new OA\Property(property: 'id', type: 'string')
        ])
    )]
    public function __invoke(Request $request, Security $security): JsonResponse
    {
        $postId = IdFactory::create();

        $author = $security->getUser();

        if (!$author instanceof Identifiable) {
            throw UnauthorizedHttpException::fromMessage('Logged user is not a identifiable user');
        }

        try {
            $payload = $request->request->all();

            $payload['authorId'] = $author->id()->toString();

            $this->commandBus->dispatch(
                CreatePostCommand::create(
                    $postId,
                    $payload
                )
            );
        } catch (ValidationExceptionInterface $e) {
            throw BadRequestHttpException::fromErrors($e->errors(), $e);
        }

        return new JsonResponse(['id' => $postId->toString()], Response::HTTP_CREATED);
    }
}
