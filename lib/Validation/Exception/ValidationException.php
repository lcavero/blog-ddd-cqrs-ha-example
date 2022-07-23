<?php

namespace Lib\Validation\Exception;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationException extends \Exception implements ValidationExceptionInterface
{
    private ConstraintViolationListInterface $violations;

    private function __construct(string $message, ConstraintViolationListInterface $violations)
    {
        $this->violations = $violations;
        parent::__construct($message);
    }

    public static function fromViolations(ConstraintViolationListInterface $violations): static
    {
        return new static('Validation failed.', $violations);
    }

    public function violations(): ConstraintViolationListInterface
    {
        return $this->violations;
    }

    public function messages(): array
    {
        $accessor = PropertyAccess::createPropertyAccessor();
        $messages = [];

        foreach ($this->violations as $violation) {
            $value   = $accessor->getValue($messages, $violation->getPropertyPath()) ?? [];
            $value[] = $violation->getMessage();
            $accessor->setValue($messages, $violation->getPropertyPath(), $value);
        }

        return $messages;
    }
}
