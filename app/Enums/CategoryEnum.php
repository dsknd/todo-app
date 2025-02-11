<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static MANAGEMENT()
 * @method static static OPERATION()
 * @method static static DEVELOPMENT()
 * @method static static RESEARCH()
 * @method static static SALES()
 * @method static static SUPPORT()
 * @method static static ADMINISTRATION()
 * @method static static LEARNING()
 * @method static static LIFE()
 * @method static static HEALTH()
 * @method static static ENTERTAINMENT()
 * @method static static COMMUNICATION()
 * @method static static ASSET()
 * @method static static COMMUNITY()
 * @method static static OTHER()
 */
enum CategoryEnum: int
{
    case UNCATEGORIZED = 1;   // 未分類
    case MANAGEMENT = 2;      // 経営
    case OPERATION = 3;       // 運営
    case DEVELOPMENT = 4;     // 開発
    case RESEARCH = 5;        // 研究
    case SALES = 6;          // 営業
    case SUPPORT = 7;        // 支援
    case ADMINISTRATION = 8;  // 管理
    case LEARNING = 9;       // 学習
    case LIFE = 10;          // 生活
    case HEALTH = 11;        // 健康
    case ENTERTAINMENT = 12;  // 遊び
    case COMMUNICATION = 13;  // 交流
    case ASSET = 14;         // 資産
    case COMMUNITY = 15;     // 地域
    case OTHER = 16;         // その他

    /**
     * カテゴリのキーを取得
     */
    public static function getKey(self $category): string
    {
        return match ($category) {
            self::UNCATEGORIZED => 'uncategorized', // 未分類
            self::MANAGEMENT => 'management',       // 経営
            self::OPERATION => 'operation',         // 運営
            self::DEVELOPMENT => 'development',   // 開発
            self::RESEARCH => 'research',         // 研究
            self::SALES => 'sales',               // 営業
            self::SUPPORT => 'support',           // 支援
            self::ADMINISTRATION => 'administration', // 管理
            self::LEARNING => 'learning',         // 学習
            self::LIFE => 'life',                 // 生活
            self::HEALTH => 'health',             // 健康
            self::ENTERTAINMENT => 'entertainment', // 遊び
            self::COMMUNICATION => 'communication', // 交流
            self::ASSET => 'asset',               // 資産
            self::COMMUNITY => 'community',       // 地域
            self::OTHER => 'other',               // その他
        };
    }
}