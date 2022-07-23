<?php

namespace App\Shared\Infrastructure\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class BadRequestHttpException extends HttpException
{
    private array $errors;

    private function __construct(array $errors, Throwable $previous = null)
    {
        $this->errors = $errors;
        parent::__construct(Response::HTTP_BAD_REQUEST, 'Invalid request', $previous);
    }

    public static function fromErrors(array $errors, Throwable $previous = null): static
    {
        return new static($errors, $previous);
    }

    public function errors(): array
    {
        return $this->errors;
    }
}
