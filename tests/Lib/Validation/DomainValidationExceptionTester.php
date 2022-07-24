<?php

namespace App\Tests\Lib\Validation;

use App\Shared\Domain\Exception\DomainValidationException;

class DomainValidationExceptionTester
{
    public static function exceptionHasError(DomainValidationException $exception, string $propertyPath, string $errorText): bool
    {
        $messages = $exception->messages();
        if (count($messages) < 1) {
            return false;
        }

        $propertyPathAsArray = explode('.', $propertyPath);

        foreach ($propertyPathAsArray as $key => $property) {
            if (!isset($messages[$property])) {
                return false;
            }

            if (count($propertyPathAsArray) - 1 === $key) {
                $errors = $messages[$property];
                if (!is_array($errors)) {
                    return false;
                }
                return in_array($errorText, $errors);
            }
        }
        return false;
    }
}
