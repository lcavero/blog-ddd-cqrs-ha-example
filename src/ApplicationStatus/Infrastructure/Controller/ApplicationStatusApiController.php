<?php

namespace App\ApplicationStatus\Infrastructure\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class ApplicationStatusApiController
{
    #[Route('/application-status/', name: 'application_status', methods: ['GET'])]
    public function status(): JsonResponse
    {
        return new JsonResponse('Ok', Response::HTTP_OK);
    }
}
