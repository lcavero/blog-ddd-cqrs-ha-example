<?php

namespace App\User\Domain\Exception;

use App\Shared\Domain\Exception\DomainException;

class UserEmailIsNotUniqueException extends DomainException
{
    public static function fromEmail(string $email): self
    {
        return new static(sprintf('User email %s is not unique', $email));
    }
}
