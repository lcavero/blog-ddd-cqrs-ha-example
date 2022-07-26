<?php

namespace App\User\Domain\Specification;

use App\User\Domain\Repository\UserReadableRepository;
use App\User\Domain\UserId;
use Lib\Validation\ValidationContext;
use Lib\Validation\ValidationContextTrait;

class UserEmailIsUniqueSpecification
{
    use ValidationContextTrait;

    public function __construct(private UserReadableRepository $repository)
    {}

    public function isSatisfiedBy(string $email, UserId $currentUserId = null, ValidationContext $context = null): bool
    {
        $filters = ['email' => $email];
        if (null !== $currentUserId) {
            $filters[] = ['id' => $currentUserId->toString()];
        }
        $existingUser = $this->repository->findBy($filters);

        if ($existingUser) {
            $this->addError('email', 'Another user already exists with this email', $email, $context);
            return false;
        }

        return true;
    }
}
