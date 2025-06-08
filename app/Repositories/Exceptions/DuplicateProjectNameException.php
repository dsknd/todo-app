<?php

namespace App\Repositories\Exceptions;

use Exception;
use Throwable;
use App\Enums\ErrorCodeEnum;
use App\Enums\ErrorMessageEnum;

class DuplicateProjectNameException extends Exception
{
    private const ERROR_CODE = ErrorCodeEnum::DUPLICATE_PROJECT_NAME->value;
    private const MESSAGE = ErrorMessageEnum::DUPLICATE_PROJECT_NAME->value;

    public function __construct(Throwable $previous)
    {
        parent::__construct(
            self::MESSAGE,
            self::ERROR_CODE,
            $previous
        );
    }
}
