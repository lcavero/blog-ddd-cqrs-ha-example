<?php

namespace App\Post\Infrastructure\Controller\Api;

use App\Post\Application\Command\CreatePostCommand;
use App\Shared\Infrastructure\Controller\Controller;
use App\Shared\Infrastructure\Exception\BadRequestHttpException;
use App\Tests\User\Domain\Mock\UserMother;
use Lib\CQRS\CommandBus;
use Lib\Validation\Exception\ValidationExceptionInterface;
use Lib\ValueObject\IdFactory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreatePostAction implements Controller
{
    public function __construct(private CommandBus $commandBus)
    {}

    #[Route('/', name: 'create_post', methods: ['POST'])]
    public function __invoke(Request $request): JsonResponse
    {
        $postId = IdFactory::create();

        try {
            $payload = $request->request->all();
            // TODO change user to current request user when authentication will be done
            $payload['author'] = UserMother::one();

            $this->commandBus->dispatch(
                CreatePostCommand::create(
                    $postId,
                    $payload
                )
            );
        } catch (ValidationExceptionInterface $e) {
            throw BadRequestHttpException::fromErrors($e->errors(), $e);
        }

        return new JsonResponse(['id' => $postId->toString(), Response::HTTP_CREATED]);
    }
}
