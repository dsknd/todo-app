<?php

namespace App\UseCases\Exceptions;

use RuntimeException;

/**
 * 既に使用されているメールアドレスに関する例外
 */
class EmailAlreadyTakenException extends RuntimeException
{
    public function __construct(string $email)
    {
        $message = "The email address '{$email}' is already taken.";
        parent::__construct($message);
    }
}