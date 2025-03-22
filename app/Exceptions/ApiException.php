<?php

namespace App\Exceptions;

use RuntimeException;
use Throwable;
class ApiException extends RuntimeException
{
    private string $type;
    private int $status;
    private string $title;
    private string $detail;
    private string $instance;
    private Throwable $previous;

    public function __construct(
        string $type,
        int $status = 500,
        string $title = '',
        string $detail = '',
        string $instance = '',
        ?Throwable $previous = null
    ) {
        $message = $title . "\n" . $detail;  
        parent::__construct($message, $status, $previous);
        $this->type = $type;
        $this->status = $status;
        $this->title = $title;
        $this->detail = $detail;
        $this->instance = $instance;
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

    public function getInstance(): string
    {
        return $this->instance;
    }
} 