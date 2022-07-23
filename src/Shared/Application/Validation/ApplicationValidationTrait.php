<?php

namespace App\Shared\Application\Validation;

use App\Shared\Application\Exception\ApplicationValidationException;
use Lib\Validation\Exception\ValidationExceptionInterface;
use Lib\Validation\ValidationTrait;
use Symfony\Component\Validator\Constraints\Collection;

trait ApplicationValidationTrait
{
    use ValidationTrait {
        ValidationTrait::validate as parentValidate;
    }

    public function validate(array $payload, Collection $constraints): void
    {
        try {
            $this->parentValidate($payload, $constraints);
        } catch (ValidationExceptionInterface $e) {
            throw ApplicationValidationException::fromViolations($e->violations());
        }
    }
}
