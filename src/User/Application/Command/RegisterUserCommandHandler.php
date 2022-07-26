<?php

namespace App\User\Application\Command;

use App\User\Domain\Service\RegisterUserService;
use App\User\Domain\User;
use Lib\CQRS\CommandHandler;

class RegisterUserCommandHandler implements CommandHandler
{
    public function __construct(private RegisterUserService $registerUserService)
    {}

    public function __invoke(RegisterUserCommand $command): void
    {
        $this->registerUserService->register(
            $command->userId(),
            $command->username(),
            $command->password(),
            $command->email(),
            $command->phone(),
            $command->website()
        );
    }
}
