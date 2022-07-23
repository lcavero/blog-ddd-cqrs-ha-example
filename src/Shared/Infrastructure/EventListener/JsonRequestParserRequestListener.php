<?php

namespace App\Shared\Infrastructure\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class JsonRequestParserRequestListener
{
    public function onKernelRequest(RequestEvent $event): void {
        $request = $event->getRequest();
        $content = $request->getContent();
        if (empty($content)) {
            return;
        }
        if (!$this->isJsonRequest($request)) {
            return;
        }
        if (!$this->transformJsonBody($request)) {
            $response = new JsonResponse(['message' =>'Unable to parse request.'], 400);
            $event->setResponse($response);
        }
    }


    private function isJsonRequest(Request $request): bool {
        return 'json' === $request->getContentType();
    }

    private function transformJsonBody(Request $request): bool {
        $data = json_decode($request->getContent(), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return false;
        }

        if ($data === null) {
            return true;
        }

        if (!is_array($data)) {
            return false;
        }

        $request->request->replace($data);
        return true;
    }
}
