<?php

namespace App\User\Domain\Event;

use App\Shared\Domain\Event\AbstractDomainEvent;
use App\User\Domain\User;

class UserWasRegisteredEvent extends AbstractDomainEvent
{
    const EVENT_NAME = 'UserWasRegistered';

    private function __construct(
        private string $id,
        private string $username,
        private string $password,
        private string $email,
        private ?string $phone,
        private ?string $website
    )
    {
        parent::__construct(self::EVENT_NAME);
    }

    public static function fromEntity(User $user): self
    {
        return new static($user->id()->toString(), $user->username(), $user->password(), $user->email(), $user->phone(), $user->website());
    }

    public function id(): string
    {
        return $this->id;
    }

    public function username(): string
    {
        return $this->username;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function phone(): ?string
    {
        return $this->phone;
    }

    public function website(): ?string
    {
        return $this->website;
    }
}
