<?php

namespace App\User\Domain\Specification;

use Lib\Validation\ValidationContext;
use Lib\Validation\ValidationContextTrait;

class UserEncryptedPasswordSpecification
{
    use ValidationContextTrait;

    const ENCRYPTED_PASSWORD_MAX_LENGTH = 255;

    public function isSatisfiedBy(?string $encryptedPassword, ValidationContext $context = null): bool
    {
        if (empty($encryptedPassword)) {
            $this->addError('encryptedPassword', 'This value should not be blank', $encryptedPassword, $context);
            return false;
        }

        if (strlen($encryptedPassword) > self::ENCRYPTED_PASSWORD_MAX_LENGTH) {
            $this->addError(
                'encryptedPassword',
                sprintf('This value should not have more than %d characters', self::ENCRYPTED_PASSWORD_MAX_LENGTH),
                $encryptedPassword,
                $context
            );
            return false;
        }

        return true;
    }
}
