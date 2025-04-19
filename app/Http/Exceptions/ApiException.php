<?php

namespace App\Http\Exceptions;

use RuntimeException;
use Throwable;
class ApiException extends RuntimeException
{
    private string $type;
    private int $status;
    private string $title;
    private string $detail;
    private Throwable $previous;

    public function __construct(
        string $type,
        int $status = 500,
        string $title = '',
        string $detail = '',
        ?Throwable $previous = null
    ) {
        $message = $title . "\n" . $detail;  
        parent::__construct($message, $status, $previous);
        $this->type = $type;
        $this->status = $status;
        $this->title = $title;
        $this->detail = $detail;
        $this->previous = $previous;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDetail(): string
    {
        return $this->detail;
    }
} 