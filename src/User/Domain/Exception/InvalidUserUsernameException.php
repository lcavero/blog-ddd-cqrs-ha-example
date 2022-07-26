<?php

namespace App\User\Domain\Exception;

use App\Shared\Domain\Exception\DomainException;

class InvalidUserUsernameException extends DomainException
{
    public static function fromUsername(string $username): self
    {
        return new static(sprintf('User username %s is not valid', $username));
    }
}
