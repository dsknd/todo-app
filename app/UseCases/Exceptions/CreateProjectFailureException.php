<?php

namespace App\UseCases\Exceptions;

use Exception;
use Throwable;
use App\Enums\ErrorMessageEnum;
use App\Enums\ErrorCodeEnum;

class CreateProjectFailureException extends Exception
{
    private const MESSAGE = ErrorMessageEnum::CREATE_PROJECT_FAILURE->value;

    public function __construct(
        ErrorCodeEnum $code,
        Throwable $previous
    ) {
        parent::__construct(self::MESSAGE, $code->value, $previous);
    }
}