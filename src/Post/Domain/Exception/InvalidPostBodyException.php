<?php

namespace App\Post\Domain\Exception;

use App\Shared\Domain\Exception\DomainException;

class InvalidPostBodyException extends DomainException
{
    public static function fromBody(string $body): self
    {
        return new static(sprintf('Post body %s is not valid', $body));
    }
}
