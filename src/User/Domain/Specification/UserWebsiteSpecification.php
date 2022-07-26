<?php

namespace App\User\Domain\Specification;

use Lib\Validation\ValidationContext;
use Lib\Validation\ValidationContextTrait;

class UserWebsiteSpecification
{
    use ValidationContextTrait;

    const WEBSITE_MAX_LENGTH = 255;

    public function isSatisfiedBy(?string $website, ValidationContext $context = null): bool
    {
        if (null === $website) {
            return true;
        }

        if ("" === $website) {
            $this->addError('website', 'This value should not be blank', $website, $context);
            return false;
        }

        if (strlen($website) > self::WEBSITE_MAX_LENGTH) {
            $this->addError('$website', sprintf('This value should not have more than %d characters', self::WEBSITE_MAX_LENGTH), $website, $context);
            return false;
        }

        return true;
    }
}
