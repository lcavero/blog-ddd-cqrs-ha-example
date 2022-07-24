<?php

namespace App\ApplicationStatus\Infrastructure\Controller\Api;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetApplicationStatusAction
{
    #[Route('/', name: 'application_status', methods: ['GET'])]
    public function __invoke(): JsonResponse
    {
        return new JsonResponse(['status' => 'Ok'], Response::HTTP_OK);
    }
}
