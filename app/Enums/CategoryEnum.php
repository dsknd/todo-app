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
            self::UNCATEGORIZED => 'UNCATEGORIZED', // 未分類
            self::MANAGEMENT => 'MANAGEMENT',       // 経営
            self::OPERATION => 'OPERATION',         // 運営
            self::DEVELOPMENT => 'DEVELOPMENT',   // 開発
            self::RESEARCH => 'RESEARCH',         // 研究
            self::SALES => 'SALES',               // 営業
            self::SUPPORT => 'SUPPORT',           // 支援
            self::ADMINISTRATION => 'ADMINISTRATION', // 管理
            self::LEARNING => 'LEARNING',         // 学習
            self::LIFE => 'LIFE',                 // 生活
            self::HEALTH => 'HEALTH',             // 健康
            self::ENTERTAINMENT => 'ENTERTAINMENT', // 遊び
            self::COMMUNICATION => 'COMMUNICATION', // 交流
            self::ASSET => 'ASSET',               // 資産
            self::COMMUNITY => 'COMMUNITY',       // 地域
            self::OTHER => 'OTHER',               // その他
        };
    }
}