<?php

namespace App\Enums;

enum TaskApprovalStatusEnum: int
{
    case PENDING = 1;
    case APPROVED = 2;
    case REJECTED = 3;
    case CANCELED = 4;

    /**
     * ステータスのキーを取得
     */
    public function key(): string
    {
        return match($this) {
            self::PENDING => 'PENDING',
            self::APPROVED => 'APPROVED',
            self::REJECTED => 'REJECTED',
            self::CANCELED => 'CANCELED',
        };
    }
} 