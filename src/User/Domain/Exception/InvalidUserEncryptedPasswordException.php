<?php

namespace App\User\Domain\Exception;

use App\Shared\Domain\Exception\DomainException;

class InvalidUserEncryptedPasswordException extends DomainException
{
    public static function fromEncryptedPassword(string $encryptedPassword): self
    {
        return new static(sprintf('User encrypted password %s is not valid', $encryptedPassword));
    }
}
