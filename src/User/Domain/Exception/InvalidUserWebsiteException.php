<?php

namespace App\User\Domain\Exception;

use App\Shared\Domain\Exception\DomainException;

class InvalidUserWebsiteException extends DomainException
{
    public static function fromWebsite(?string $website): self
    {
        return new static(sprintf('User website %s is not valid', $website));
    }
}
