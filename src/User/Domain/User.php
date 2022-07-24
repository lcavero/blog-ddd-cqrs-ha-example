<?php

namespace App\User\Domain;

class User
{
    private string $id;

    private function __construct(UserId $userId)
    {
        $this->id = $userId->toString();
    }

    public static function create(UserId $userId): self
    {
        return new static($userId);
    }

    public function id(): UserId
    {
        return UserId::fromString($this->id);
    }
}
