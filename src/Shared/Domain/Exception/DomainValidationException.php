<?php

namespace App\Shared\Domain\Exception;

use Lib\Validation\Exception\ValidationException;
use Lib\Validation\Exception\ValidationExceptionInterface;

class DomainValidationException extends ValidationException implements ValidationExceptionInterface
{
}
