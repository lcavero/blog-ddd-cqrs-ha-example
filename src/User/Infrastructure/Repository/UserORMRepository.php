<?php

namespace App\User\Infrastructure\Repository;

use App\User\Domain\Repository\UserRepository;
use App\User\Domain\User;
use App\User\Domain\UserId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UserORMRepository extends ServiceEntityRepository implements UserRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findAll(): array
    {
        return parent::findAll();
    }

    public function findOne(UserId $userId): ?User
    {
        return $this->find($userId->toString());
    }

    public function create(User $user): void
    {
        $this->getEntityManager()->persist($user);
    }

    public function update(User $user): void
    {
        // Unnecessary implementation
    }
}
