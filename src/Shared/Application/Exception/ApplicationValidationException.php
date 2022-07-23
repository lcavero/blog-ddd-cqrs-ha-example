<?php

namespace App\Shared\Application\Exception;

use Lib\Validation\Exception\ValidationException;
use Lib\Validation\Exception\ValidationExceptionInterface;

class ApplicationValidationException extends ValidationException implements ValidationExceptionInterface
{
}
