<?php

namespace App\ApplicationStatus\Infrastructure\Controller\Api;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

class GetApplicationStatusAction
{
    #[Route('/', name: 'application_status', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Return the server status',
        content: new OA\JsonContent(type: 'object', properties: [
            new OA\Property(property: 'status', type: 'bool')
        ])
    )]
    public function __invoke(): JsonResponse
    {
        return new JsonResponse(['status' => 'Ok'], Response::HTTP_OK);
    }
}
