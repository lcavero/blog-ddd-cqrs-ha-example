<?php

namespace App\Shared\Domain\Validation;

use App\Shared\Domain\Exception\DomainValidationException;
use Lib\Validation\Exception\ValidationExceptionInterface;
use Lib\Validation\ValidationTrait;
use Symfony\Component\Validator\Constraints\Collection;

trait DomainValidationTrait
{
    use ValidationTrait {
        ValidationTrait::validate as parentValidate;
    }

    public function validate(array $payload, Collection $constraints): void
    {
        try {
            $this->parentValidate($payload, $constraints);
        } catch (ValidationExceptionInterface $e) {
            throw DomainValidationException::fromViolations($e->violations());
        }
    }
}
