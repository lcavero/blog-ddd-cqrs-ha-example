<?php

namespace App\User\Domain\Service;

use App\User\Domain\Exception\InvalidUserPlainPasswordException;
use App\User\Domain\Repository\UserRepository;
use App\User\Domain\Specification\UserPlainPasswordSpecification;
use App\User\Domain\User;
use App\User\Domain\UserId;
use Lib\CQRS\EventBus;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterUserService
{
    public function __construct(
        private UserRepository $repository,
        private EventBus $eventBus,
        private PasswordHasherFactoryInterface $passwordHasherFactory
    )
    {}

    public function register(UserId $userId, string $username, string $password, string $email, ?string $phone, ?string $website): void
    {
        $passwordSpecification = new UserPlainPasswordSpecification();
        if (!$passwordSpecification->isSatisfiedBy($password)) {
            throw InvalidUserPlainPasswordException::fromPassword($password);
        }

        $passwordHasher = $this->passwordHasherFactory->getPasswordHasher(User::class);

        $encryptedPassword = $passwordHasher->hash($password);

        $user = User::register($userId, $username, $encryptedPassword, $email, $phone, $website);

        $this->repository->create($user);

        $this->eventBus->dispatch(...$user->pullDomainEvents());
    }
}
