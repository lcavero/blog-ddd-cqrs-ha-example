<?php

namespace App\User\Domain;

use App\Shared\Domain\Aggregate\AggregateRoot;
use App\Shared\Domain\Event\DomainEventsRecorderTrait;
use App\Shared\Domain\Validation\DomainValidationTrait;
use App\User\Domain\Event\UserWasRegisteredEvent;
use App\User\Domain\Exception\InvalidUserEmailException;
use App\User\Domain\Exception\InvalidUserEncryptedPasswordException;
use App\User\Domain\Exception\InvalidUserPhoneException;
use App\User\Domain\Exception\InvalidUserUsernameException;
use App\User\Domain\Exception\InvalidUserWebsiteException;
use App\User\Domain\Specification\UserEmailSpecification;
use App\User\Domain\Specification\UserEncryptedPasswordSpecification;
use App\User\Domain\Specification\UserPhoneSpecification;
use App\User\Domain\Specification\UserUsernameSpecification;
use App\User\Domain\Specification\UserWebsiteSpecification;
use Lib\Security\Identifiable;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface, PasswordAuthenticatedUserInterface, Identifiable, AggregateRoot
{
    use DomainValidationTrait;
    use DomainEventsRecorderTrait;

    private string $id;
    private string $username;
    private string $password;
    private string $email;
    private ?string $phone;
    private ?string $website;

    private function __construct(UserId $userId, string $username, string $password, string $email, ?string $phone, ?string $website)
    {
        $this->setId($userId);
        $this->setUsername($username);
        $this->setPassword($password);
        $this->setEmail($email);
        $this->setPhone($phone);
        $this->setWebsite($website);
    }

    public static function register(UserId $userId, string $username, string $password, string $email, ?string $phone, ?string $website): self
    {
        $user = new static($userId, $username, $password, $email, $phone, $website);
        $user->record(UserWasRegisteredEvent::fromEntity($user));
        return $user;
    }

    public function id(): UserId
    {
        return UserId::fromString($this->id);
    }

    private function setId(UserId $userId): void
    {
        $this->id = $userId->toString();
    }

    public function username(): string
    {
        return $this->username;
    }

    private function setUsername(string $username): void
    {
        $specification = new UserUsernameSpecification();
        if (!$specification->isSatisfiedBy($username)) {
            throw InvalidUserUsernameException::fromUsername($username);
        }
        $this->username = $username;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    private function setPassword(string $password): void
    {
        $specification = new UserEncryptedPasswordSpecification();
        if (!$specification->isSatisfiedBy($password)) {
            throw InvalidUserEncryptedPasswordException::fromEncryptedPassword($password);
        }
        $this->password = $password;
    }

    public function email(): string
    {
        return $this->email;
    }

    private function setEmail(string $email): void
    {
        $specification = new UserEmailSpecification();
        if (!$specification->isSatisfiedBy($email)) {
            throw InvalidUserEmailException::fromEmail($email);
        }
        $this->email = $email;
    }

    public function phone(): ?string
    {
        return $this->phone;
    }

    private function setPhone(?string $phone): void
    {
        $specification = new UserPhoneSpecification();
        if (!$specification->isSatisfiedBy($phone)) {
            throw InvalidUserPhoneException::fromPhone($phone);
        }
        $this->phone = $phone;
    }

    public function website(): ?string
    {
        return $this->website;
    }

    private function setWebsite(?string $website): void
    {
        $specification = new UserWebsiteSpecification();
        if (!$specification->isSatisfiedBy($website)) {
            throw InvalidUserWebsiteException::fromWebsite($website);
        }
        $this->website = $website;
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
