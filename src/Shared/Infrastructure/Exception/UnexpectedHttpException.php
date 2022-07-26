<?php

namespace App\Shared\Infrastructure\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class UnexpectedHttpException extends HttpException
{
    private function __construct(string $message, Throwable $previous = null)
    {
        parent::__construct(Response::HTTP_INTERNAL_SERVER_ERROR, $message, $previous);
    }

    public static function fromMessage(string $message, Throwable $previous = null): static
    {
        return new static($message, $previous);
    }
}
