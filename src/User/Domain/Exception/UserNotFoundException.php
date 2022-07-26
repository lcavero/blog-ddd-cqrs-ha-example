<?php

namespace App\User\Domain\Exception;

use App\Shared\Domain\Exception\DomainException;
use App\User\Domain\UserId;

class UserNotFoundException extends DomainException
{
    private function __construct(string $message)
    {
        parent::__construct($message);
    }

    public static function fromUserId(UserId $userId): self
    {
        return new static(sprintf('The User with id %s was not found', $userId->toString()));
    }
}
