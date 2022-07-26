<?php

namespace App\User\Infrastructure\Controller\Api;

use App\Shared\Infrastructure\Controller\Controller;
use App\Shared\Infrastructure\Exception\BadRequestHttpException;
use App\User\Application\Command\RegisterUserCommand;
use Lib\CQRS\CommandBus;
use Lib\Validation\Exception\ValidationExceptionInterface;
use Lib\ValueObject\IdFactory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

class RegisterUserAction implements Controller
{
    public function __construct(private CommandBus $commandBus)
    {}

    #[Route('/register/', name: 'register_user', methods: ['POST'])]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(type: 'object', properties: [
            new OA\Property(property: 'username',  type: 'string'),
            new OA\Property(property: 'password',  type: 'string'),
            new OA\Property(property: 'email',  type: 'string'),
            new OA\Property(property: 'phone',  type: 'string'),
            new OA\Property(property: 'website',  type: 'string'),
        ])
    )]
    #[OA\Response(
        response: 201,
        description: 'Register a user',
        content: new OA\JsonContent(type: 'object', properties: [
            new OA\Property(property: 'id', type: 'string')
        ])
    )]
    public function __invoke(Request $request): JsonResponse
    {
        $userId = IdFactory::create();

        try {
            $this->commandBus->dispatch(RegisterUserCommand::create($userId, $request->request->all()));
        } catch (ValidationExceptionInterface $e) {
            throw BadRequestHttpException::fromErrors($e->errors(), $e);
        }

        return new JsonResponse(['id' => $userId->toString()], Response::HTTP_CREATED);
    }
}
