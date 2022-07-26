<?php

namespace App\Post\Domain\Specification;

use Lib\Validation\ValidationContext;
use Lib\Validation\ValidationContextTrait;

class PostTitleSpecification
{
    use ValidationContextTrait;

    const TITLE_MAX_LENGTH = 255;

    public function isSatisfiedBy(?string $title, ValidationContext $context = null): bool
    {
        if (empty($title)) {
            $this->addError('title', 'This value should not be blank', $title, $context);
            return false;
        }

        if (strlen($title) > self::TITLE_MAX_LENGTH) {
            $this->addError('title', sprintf('This value should not have more than %d characters', self::TITLE_MAX_LENGTH), $title, $context);
            return false;
        }

        return true;
    }
}
