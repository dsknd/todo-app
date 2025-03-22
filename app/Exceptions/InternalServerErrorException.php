<?php

namespace App\Exceptions;

use RuntimeException;
use Throwable;
class InternalServerErrorException extends RuntimeException
{
    /**
     * コンストラクタ
     *
     * @param ?string $message メッセージ
     * @param Throwable $previous 前の例外
     */
    public function __construct(string $message = "Internal Server Error", Throwable $previous)
    {
        parent::__construct($message, 0, $previous);
    }
}