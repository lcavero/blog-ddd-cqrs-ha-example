<?php

namespace App\Post\Domain\Specification;

use App\User\Domain\UserId;
use Exception;
use Lib\Validation\ValidationContext;
use Lib\Validation\ValidationContextTrait;

class PostAuthorIdSpecification
{
    use ValidationContextTrait;

    public function isSatisfiedBy(?string $authorId, ValidationContext $context = null): bool
    {
        if (null === $authorId) {
            $this->addError('authorId', 'This value should not be blank', $authorId, $context);
            return false;
        }

        try {
            UserId::fromString($authorId);
        } catch (Exception) {
            $this->addError('authorId', 'This value is not valid', $authorId, $context);
            return false;
        }

        return true;
    }
}
