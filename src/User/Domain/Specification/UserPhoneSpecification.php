<?php

namespace App\User\Domain\Specification;

use Lib\Validation\ValidationContext;
use Lib\Validation\ValidationContextTrait;

class UserPhoneSpecification
{
    use ValidationContextTrait;

    const PHONE_MAX_LENGTH = 20;

    public function isSatisfiedBy(?string $phone, ValidationContext $context = null): bool
    {
        if (null === $phone) {
            return true;
        }

        if ("" === $phone) {
            $this->addError('phone', 'This value should not be blank', $phone, $context);
            return false;
        }

        if (strlen($phone) > self::PHONE_MAX_LENGTH) {
            $this->addError('phone', sprintf('This value should not have more than %d characters', self::PHONE_MAX_LENGTH), $phone, $context);
            return false;
        }

        if(!preg_match('/^\+?(6\d{2}|7[1-9]\d{1})\d{6}$/', $phone)) {
            $this->addError('phone', 'This value not match a valid phone', $phone, $context);
            return false;
        }

        return true;
    }
}
