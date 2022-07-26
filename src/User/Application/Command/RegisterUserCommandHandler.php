<?php

namespace App\User\Application\Command;

use App\Shared\Application\Exception\ApplicationValidationException;
use App\User\Domain\Service\RegisterUserService;
use App\User\Domain\Specification\UserEmailIsUniqueSpecification;
use App\User\Domain\Specification\UserUsernameIsUniqueSpecification;
use Lib\CQRS\CommandHandler;
use Lib\Validation\ValidationContext;

class RegisterUserCommandHandler implements CommandHandler
{
    private ValidationContext $context;

    public function __construct(
        private RegisterUserService $registerUserService,
        private UserEmailIsUniqueSpecification $emailIsUniqueSpecification,
        private UserUsernameIsUniqueSpecification $usernameIsUniqueSpecification
    )
    {
        $this->context = ValidationContext::create();
    }

    public function __invoke(RegisterUserCommand $command): void
    {
        $this->emailIsUniqueSpecification->isSatisfiedBy($command->email(), null, $this->context);
        $this->usernameIsUniqueSpecification->isSatisfiedBy($command->username(), null, $this->context);

        if ($this->context->hasErrors()) {
            throw ApplicationValidationException::fromViolations($this->context->errors());
        }

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
