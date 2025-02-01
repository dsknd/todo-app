<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static WORK()
 * @method static static PERSONAL()
 * @method static static STUDY()
 * @method static static HOBBY()
 * @method static static OTHER()
 */
enum CategoryEnum: int
{
    case WORK = 1;         // 仕事
    case PERSONAL = 2;     // 個人
    case STUDY = 3;        // 学習
    case HOBBY = 4;        // 趣味
    case OTHER = 5;        // その他

    /**
     * カテゴリの表示名を取得
     */
    public static function getDisplayName(self $category): string
    {
        return match ($category) {
            self::WORK => '仕事',
            self::PERSONAL => '個人',
            self::STUDY => '学習',
            self::HOBBY => '趣味',
            self::OTHER => 'その他',
        };
    }

    /**
     * カテゴリの説明を取得
     */
    public static function getDescription(self $category): string
    {
        return match ($category) {
            self::WORK => '仕事関連のタスク',
            self::PERSONAL => '個人的なタスク',
            self::STUDY => '学習・勉強関連のタスク',
            self::HOBBY => '趣味関連のタスク',
            self::OTHER => 'その他のタスク',
        };
    }
}