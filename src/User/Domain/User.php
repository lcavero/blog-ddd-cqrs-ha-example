<?php

namespace App\User\Domain;

use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
{
    private string $id;
    private string $username;
    private string $password;
    private string $email;
    private ?string $phone;
    private ?string $website;

    private function __construct(UserId $userId, string $username, string $password, string $email, ?string $phone, ?string $website)
    {
        $this->id = $userId->toString();
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->phone = $phone;
        $this->website = $website;
    }

    public static function create(UserId $userId, string $username, string $password, string $email, ?string $phone, ?string $website): self
    {
        return new static($userId, $username, $password, $email, $phone, $website);
    }

    public function id(): UserId
    {
        return UserId::fromString($this->id);
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

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->username;
    }
}
