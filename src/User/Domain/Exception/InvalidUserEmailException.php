<?php

namespace App\User\Domain\Exception;

use App\Shared\Domain\Exception\DomainException;

class InvalidUserEmailException extends DomainException
{
    public static function fromEmail(string $email): self
    {
        return new static(sprintf('User email %s is not valid', $email));
    }
}
