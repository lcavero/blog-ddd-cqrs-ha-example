<?php

namespace Lib\Validation;

use Lib\Validation\Exception\ValidationException;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Validation;

trait ValidationTrait
{
    public function validate(array $payload, Collection $constraints): void
    {
        $validator = Validation::createValidator();
        $violations = $validator->validate($payload, $constraints);
        if (count($violations) !== 0) {
            throw ValidationException::fromViolations($violations);
        }
    }
}
