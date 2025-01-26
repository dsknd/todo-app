<?php

namespace App\Enums;

enum ProjectRoleTypes: string
{
    case CUSTOM = 'custom';     // カスタムロール
    case DEFAULT = 'default';   // デフォルトロール

    /**
     * ロールタイプの説明を取得
     */
    public function getDescription(): string
    {
        return match($this) {
            self::CUSTOM => 'プロジェクト固有のカスタムロール',
            self::DEFAULT => 'システム定義のデフォルトロール',
        };
    }
}
