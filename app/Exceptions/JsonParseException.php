<?php

namespace App\Exceptions;

use Exception;

class JsonParseException extends Exception
{
    public function __construct($message = 'Invalid JSON syntax.', $code = 400, ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
