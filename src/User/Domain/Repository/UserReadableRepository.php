<?php

namespace App\User\Domain\Repository;

use App\User\Domain\User;
use App\User\Domain\UserId;

interface UserReadableRepository
{
    public function findAll(): array;
    public function findOne(UserId $postId): ?User;
    public function findBy(array $filters, ?array $orderBy = null, $limit = null, $offset = null): array;
}
