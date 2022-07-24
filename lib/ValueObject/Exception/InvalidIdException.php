<?php

namespace Lib\ValueObject\Exception;

use Exception;
use Throwable;

class InvalidIdException extends Exception
{
    private function __construct($message, Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }

    public static function create(string $message, Throwable $previous = null): static
    {
        return new static($message, $previous);
    }
}
