<?php

namespace App\UseCases\Exceptions;

use Exception;
use Throwable;

class ApplicationException extends Exception
{
    public function __construct(
        string $message,
        int $code,
        Throwable $previous
    ) {
        parent::__construct($message, $code, $previous);
    }
}
