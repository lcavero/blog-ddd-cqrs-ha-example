<?php

namespace App\Post\Domain\Exception;

use App\Shared\Domain\Exception\DomainException;

class InvalidPostTitleException extends DomainException
{
    public static function fromTitle(string $title): self
    {
        return new static(sprintf('Post title %s is not valid', $title));
    }
}
