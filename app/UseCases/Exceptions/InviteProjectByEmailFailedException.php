<?php

namespace App\UseCases\Exceptions;

use Exception;
use App\ValueObjects\ErrorCode;
use App\ValueObjects\ErrorMessage;
use App\Enums\ErrorMessageEnum;

class InviteProjectByEmailFailedException extends Exception
{
    protected $message;

    public function __construct(
        ErrorCode $code,
        Exception $previous
    ) {
        $this->message = ErrorMessage::fromEnum(ErrorMessageEnum::INVITE_PROJECT_BY_EMAIL_FAILED);
        parent::__construct($this->message, $code, $previous);
    }
}