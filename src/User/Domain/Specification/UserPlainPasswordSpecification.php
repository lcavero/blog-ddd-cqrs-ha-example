<?php

namespace App\User\Domain\Specification;

use Lib\Validation\ValidationContext;
use Lib\Validation\ValidationContextTrait;

class UserPlainPasswordSpecification
{
    use ValidationContextTrait;

    const PLAIN_PASSWORD_MIN_LENGTH = 5;
    const PLAIN_PASSWORD_MAX_LENGTH = 15;

    public function isSatisfiedBy(?string $plainPassword, ValidationContext $context = null): bool
    {
        if (empty($plainPassword)) {
            $this->addError('password', 'This value should not be blank', $plainPassword, $context);
            return false;
        }

        if (strlen($plainPassword) < self::PLAIN_PASSWORD_MIN_LENGTH) {
            $this->addError('password', sprintf('This value should not have less than %d characters', self::PLAIN_PASSWORD_MIN_LENGTH), $plainPassword, $context);
            return false;
        }

        if (strlen($plainPassword) > self::PLAIN_PASSWORD_MAX_LENGTH) {
            $this->addError('password', sprintf('This value should not have more than %d characters', self::PLAIN_PASSWORD_MAX_LENGTH), $plainPassword, $context);
            return false;
        }

        return true;
    }
}
