<?php

namespace App\User\Domain\Exception;

use App\Shared\Domain\Exception\DomainException;

class InvalidUserPlainPasswordException extends DomainException
{
    public static function fromPassword(string $password): self
    {
        return new static(sprintf('User plain password %s is not valid', $password));
    }
}
