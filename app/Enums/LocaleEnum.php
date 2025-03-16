<?php

namespace App\Enums;

/**
 * システムで利用可能な言語を管理するEnum
 */
enum LocaleEnum: int
{
    case JAPANESE = 1;
    case ENGLISH = 2;

    /**
     * 言語コードを取得
     */
    public static function getLanguageCode(self $locale): string
    {
        return match ($locale) {
            self::JAPANESE => 'ja',
            self::ENGLISH => 'en',
        };
    }

    /**
     * 地域コードを取得
     */
    public static function getRegionCode(self $locale): string
    {
        return match ($locale) {
            self::JAPANESE => 'JP',
            self::ENGLISH => 'US',
        };
    }

    /**
     * スクリプトコードを取得
     */
    public static function getScriptCode(self $locale): ?string
    {
        return match ($locale) {
            self::JAPANESE => 'Jpan',
            self::ENGLISH => 'Latn',
        };
    }

    /**
     * BCP47形式のコードを取得
     */
    public static function getFormatBcp47(self $locale): string
    {
        return match ($locale) {
            self::JAPANESE => 'ja-JP',
            self::ENGLISH => 'en-US',
        };
    }

    /**
     * CLDR形式のコードを取得
     */
    public static function getFormatCldr(self $locale): string
    {
        return match ($locale) {
            self::JAPANESE => 'ja_JP',
            self::ENGLISH => 'en_US',
        };
    }

    /**
     * POSIX形式のコードを取得
     */
    public static function getFormatPosix(self $locale): string
    {
        return match ($locale) {
            self::JAPANESE => 'ja_JP.UTF-8',
            self::ENGLISH => 'en_US.UTF-8',
        };
    }

    /**
     * ロケール名を取得
     */
    public static function getName(self $locale): string
    {
        return match ($locale) {
            self::JAPANESE => '日本語（日本）',
            self::ENGLISH => 'English (United States)',
        };
    }

    /**
     * ネイティブ表記のロケール名を取得
     */
    public static function getNativeName(self $locale): string
    {
        return match ($locale) {
            self::JAPANESE => '日本語（日本）',
            self::ENGLISH => 'English (United States)',
        };
    }

    /**
     * アクティブ状態を取得
     */
    public static function isActive(self $locale): bool
    {
        return match ($locale) {
            self::JAPANESE => true,
            self::ENGLISH => true,
        };
    }

    /**
     * 短い日付形式を取得
     */
    public static function getDateFormatShort(self $locale): string
    {
        return match ($locale) {
            self::JAPANESE => 'Y/m/d',
            self::ENGLISH => 'n/j/Y',
        };
    }

    /**
     * 中程度の日付形式を取得
     */
    public static function getDateFormatMedium(self $locale): string
    {
        return match ($locale) {
            self::JAPANESE => 'Y年n月j日',
            self::ENGLISH => 'M j, Y',
        };
    }

    /**
     * 長い日付形式を取得
     */
    public static function getDateFormatLong(self $locale): string
    {
        return match ($locale) {
            self::JAPANESE => 'Y年n月j日(D)',
            self::ENGLISH => 'l, F j, Y',
        };
    }

    /**
     * 短い時間形式を取得
     */
    public static function getTimeFormatShort(self $locale): string
    {
        return match ($locale) {
            self::JAPANESE => 'H:i',
            self::ENGLISH => 'g:i a',
        };
    }

    /**
     * 中程度の時間形式を取得
     */
    public static function getTimeFormatMedium(self $locale): string
    {
        return match ($locale) {
            self::JAPANESE => 'H:i:s',
            self::ENGLISH => 'g:i:s a',
        };
    }

    /**
     * 短い日時形式を取得
     */
    public static function getDatetimeFormatShort(self $locale): string
    {
        return match ($locale) {
            self::JAPANESE => 'Y/m/d H:i',
            self::ENGLISH => 'n/j/Y, g:i a',
        };
    }

    /**
     * 週の最初の曜日を取得
     */
    public static function getFirstDayOfWeek(self $locale): string
    {
        return match ($locale) {
            self::JAPANESE => 'monday',
            self::ENGLISH => 'sunday',
        };
    }

    /**
     * 24時間形式を使用するかどうかを取得
     */
    public static function is24HourFormat(self $locale): bool
    {
        return match ($locale) {
            self::JAPANESE => true,
            self::ENGLISH => false,
        };
    }

    /**
     * デフォルトのタイムゾーンを取得
     */
    public static function getDefaultTimezone(self $locale): string
    {
        return match ($locale) {
            self::JAPANESE => 'Asia/Tokyo',
            self::ENGLISH => 'America/New_York',
        };
    }
} 