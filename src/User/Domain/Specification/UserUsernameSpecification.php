<?php

namespace App\User\Domain\Specification;

use Lib\Validation\ValidationContext;
use Lib\Validation\ValidationContextTrait;

class UserUsernameSpecification
{
    use ValidationContextTrait;

    const USERNAME_MAX_LENGTH = 255;

    public function isSatisfiedBy(?string $username, ValidationContext $context = null): bool
    {
        if (empty($username)) {
            $this->addError('username', 'This value should not be blank', $username, $context);
            return false;
        }

        if (strlen($username) > self::USERNAME_MAX_LENGTH) {
            $this->addError('username', sprintf('This value should not have more than %d characters', self::USERNAME_MAX_LENGTH), $username, $context);
            return false;
        }

        return true;
    }
}
