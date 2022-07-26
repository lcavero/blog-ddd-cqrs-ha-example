<?php

namespace App\User\Domain\Exception;

use App\Shared\Domain\Exception\DomainException;

class UserUsernameIsNotUniqueException extends DomainException
{
    public static function fromUsername(string $username): self
    {
        return new static(sprintf('User username %s is not unique', $username));
    }
}
