<?php

namespace App\Enums;

/**
 * システムで利用可能な言語を管理するEnum
 * 
 * 値はISO 639-1の言語コードを使用
 */
enum LocaleEnum: int
{
    case JAPANESE = 1;
    case ENGLISH = 2;

    public static function getCode(self $locale, LanguageCodeStandardEnum $standard): string
    {
        return match ($standard) {
            LanguageCodeStandardEnum::ISO_639_1 => match ($locale) {
                self::JAPANESE => 'ja',
                self::ENGLISH => 'en',
            },
            LanguageCodeStandardEnum::IETF_BCP_47 => match ($locale) {
                self::JAPANESE => 'ja-JP',
                self::ENGLISH => 'en-US',
            },
        };
    }

    public static function getName(self $locale): string
    {
        return match ($locale) {
            self::JAPANESE => '日本語',
            self::ENGLISH => 'English',
        };
    }

    public static function isActive(self $locale): bool
    {
        return match ($locale) {
            self::JAPANESE => true,
            self::ENGLISH => true,
        };
    }
} 