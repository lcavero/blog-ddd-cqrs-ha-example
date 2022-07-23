<?php

namespace Lib\Validation\Exception;

use Symfony\Component\Validator\ConstraintViolationListInterface;

interface ValidationExceptionInterface extends \Throwable
{
    public function violations(): ConstraintViolationListInterface;
    public function messages(): array;
}
