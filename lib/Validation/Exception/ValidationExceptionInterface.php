<?php

namespace Lib\Validation\Exception;

use Symfony\Component\Validator\ConstraintViolationListInterface;
use Throwable;

interface ValidationExceptionInterface extends Throwable
{
    public function violations(): ConstraintViolationListInterface;
    public function errors(): array;
}
