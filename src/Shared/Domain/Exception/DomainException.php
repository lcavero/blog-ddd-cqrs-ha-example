<?php

namespace App\Shared\Domain\Exception;

use Throwable;

class DomainException extends \DomainException
{
    protected function __construct(string $message, Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }

    public static function create(string $message, Throwable $previous = null): static
    {
        return new static($message, $previous);
    }
}
