<?php

namespace App\Post\Domain\Specification;

use Lib\Validation\ValidationContext;
use Lib\Validation\ValidationContextTrait;

class PostBodySpecification
{
    use ValidationContextTrait;

    const BODY_MAX_LENGTH = 1000;

    public function isSatisfiedBy(?string $body, ValidationContext $context = null): bool
    {
        if (empty($body)) {
            $this->addError('body', 'This value should not be blank', $body, $context);
            return false;
        }

        if (strlen($body) > self::BODY_MAX_LENGTH) {
            $this->addError('body', sprintf('This value should not have more than %d characters', self::BODY_MAX_LENGTH), $body, $context);
            return false;
        }

        return true;
    }
}
