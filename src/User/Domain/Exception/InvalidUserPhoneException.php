<?php

namespace App\User\Domain\Exception;

use App\Shared\Domain\Exception\DomainException;

class InvalidUserPhoneException extends DomainException
{
    public static function fromPhone(?string $phone): self
    {
        return new static(sprintf('User phone %s is not valid', $phone));
    }
}
