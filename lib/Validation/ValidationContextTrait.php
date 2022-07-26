<?php

namespace Lib\Validation;

use Symfony\Component\Validator\ConstraintViolation;

trait ValidationContextTrait
{
    private function addError(string $propertyPath, string $message, mixed $invalidValue, ValidationContext $context = null): void
    {
        if (!$context) {
            return;
        }

        $error = new ConstraintViolation($message, $message, [], null, sprintf('[%s]', $propertyPath), $invalidValue);

        $context->addError($error);
    }
}
