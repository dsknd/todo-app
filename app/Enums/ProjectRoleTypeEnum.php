<?php

namespace App\Enums;

enum ProjectRoleTypeEnum: int
{
    case CUSTOM = 1;     // カスタムロール
    case DEFAULT = 2;   // デフォルトロール

    /**
     * ロールタイプのキーを取得
     */
    public function getKey(): string
    {
        return match($this) {
            self::CUSTOM => 'custom',
            self::DEFAULT => 'default',
        };
    }
}
