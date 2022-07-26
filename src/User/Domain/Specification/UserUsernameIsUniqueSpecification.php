<?php

namespace App\User\Domain\Specification;

use App\User\Domain\Repository\UserReadableRepository;
use App\User\Domain\UserId;
use Lib\Validation\ValidationContext;
use Lib\Validation\ValidationContextTrait;

class UserUsernameIsUniqueSpecification
{
    use ValidationContextTrait;

    public function __construct(private UserReadableRepository $repository)
    {}

    public function isSatisfiedBy(string $username, UserId $currentUserId = null, ValidationContext $context = null): bool
    {
        $filters = ['username' => $username];
        if (null !== $currentUserId) {
            $filters[] = ['id' => $currentUserId->toString()];
        }
        $existingUser = $this->repository->findBy($filters);

        if ($existingUser) {
            $this->addError('username', 'Another user already exists with this username', $username, $context);
            return false;
        }

        return true;
    }
}
