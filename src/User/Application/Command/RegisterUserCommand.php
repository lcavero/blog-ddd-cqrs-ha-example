<?php

namespace App\User\Application\Command;

use App\Shared\Application\Exception\ApplicationValidationException;
use App\User\Domain\Specification\UserEmailSpecification;
use App\User\Domain\Specification\UserPhoneSpecification;
use App\User\Domain\Specification\UserPlainPasswordSpecification;
use App\User\Domain\Specification\UserUsernameSpecification;
use App\User\Domain\Specification\UserWebsiteSpecification;
use App\User\Domain\UserId;
use Lib\CQRS\Command;
use Lib\Validation\ValidationContext;
use Lib\ValueObject\Id;

class RegisterUserCommand implements Command
{
    private ValidationContext $context;

    private UserId $userId;
    private string $username;
    private string $password;
    private string $email;
    private ?string $phone;
    private ?string $website;

    private function __construct(Id $userId, array $payload)
    {
        $this->context = ValidationContext::create();
        $this->setUserId($userId);
        $this->setUsername($payload['username'] ?? null);
        $this->setPassword($payload['password'] ?? null);
        $this->setEmail($payload['email'] ?? null);
        $this->setPhone($payload['phone'] ?? null);
        $this->setWebsite($payload['website'] ?? null);

        if ($this->context->hasErrors()) {
            throw ApplicationValidationException::fromViolations($this->context->errors());
        }
    }

    public static function create(Id $userId, array $payload): self
    {
        return new static($userId, $payload);
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    private function setUserId(Id $userId): void
    {
        $this->userId = UserId::fromId($userId);
    }

    public function username(): string
    {
        return $this->username;
    }

    private function setUsername(?string $username): void
    {
        $specification = new UserUsernameSpecification();
        if ($specification->isSatisfiedBy($username, $this->context)) {
            $this->username = $username;
        }
    }

    public function password(): string
    {
        return $this->password;
    }

    private function setPassword(?string $password): void
    {
        $specification = new UserPlainPasswordSpecification();
        if ($specification->isSatisfiedBy($password, $this->context)) {
            $this->password = $password;
        }
    }

    public function email(): string
    {
        return $this->email;
    }

    private function setEmail(?string $email): void
    {
        $specification = new UserEmailSpecification();
        if ($specification->isSatisfiedBy($email, $this->context)) {
            $this->email = $email;
        }
    }

    public function phone(): ?string
    {
        return $this->phone;
    }

    private function setPhone(?string $phone): void
    {
        $specification = new UserPhoneSpecification();
        if ($specification->isSatisfiedBy($phone, $this->context)) {
            $this->phone = $phone;
        }
    }

    public function website(): ?string
    {
        return $this->website;
    }

    private function setWebsite(?string $website): void
    {
        $specification = new UserWebsiteSpecification();
        if ($specification->isSatisfiedBy($website, $this->context)) {
            $this->website = $website;
        }
    }
}
