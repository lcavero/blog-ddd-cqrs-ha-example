<?php

namespace Lib\Validation;

use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationContext
{
    private ConstraintViolationListInterface $errors;

    private function __construct()
    {
        $this->errors = new ConstraintViolationList();
    }

    public static function create(): self
    {
        return new static();
    }

    public function addError(ConstraintViolationInterface $error)
    {
        $this->errors->add($error);
    }

    public function errors(): ConstraintViolationListInterface
    {
        return $this->errors;
    }

    public function hasErrors(): bool
    {
        return $this->errors->count() > 0;
    }
}
