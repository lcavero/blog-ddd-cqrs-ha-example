<?php

namespace App\User\Domain\Specification;

use Lib\Validation\ValidationContext;
use Lib\Validation\ValidationContextTrait;

class UserEmailSpecification
{
    use ValidationContextTrait;

    const EMAIL_MAX_LENGTH = 255;

    public function isSatisfiedBy(?string $email, ValidationContext $context = null): bool
    {
        if (empty($email)) {
            $this->addError('email', 'This value should not be blank', $email, $context);
            return false;
        }

        if (strlen($email) > self::EMAIL_MAX_LENGTH) {
            $this->addError('email', sprintf('This value should not have more than %d characters', self::EMAIL_MAX_LENGTH), $email, $context);
            return false;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->addError('email', 'This value  not match a valid email', $email, $context);
            return false;
        }

        return true;
    }
}
