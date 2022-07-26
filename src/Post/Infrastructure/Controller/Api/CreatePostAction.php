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

class CreatePostAction implements Controller
{
    public function __construct(private CommandBus $commandBus)
    {}

    #[Route('/', name: 'create_post', methods: ['POST'])]
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
