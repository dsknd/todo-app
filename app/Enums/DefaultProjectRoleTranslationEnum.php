<?php

namespace App\Enums;

use App\Enums\DefaultProjectRoleEnum;

enum DefaultProjectRoleTranslationEnum: string
{
    case OWNER_NAME_JA = 'オーナー';
    case ADMIN_NAME_JA = '管理者';
    case MEMBER_NAME_JA = 'メンバー';
    case VIEWER_NAME_JA = '閲覧者';
    case GUEST_NAME_JA = 'ゲスト';

    case OWNER_NAME_EN = 'Owner';
    case ADMIN_NAME_EN = 'Admin';
    case MEMBER_NAME_EN = 'Member';
    case VIEWER_NAME_EN = 'Viewer';
    case GUEST_NAME_EN = 'Guest';

    case OWNER_DESCRIPTION_JA = 'プロジェクトのオーナーです。';
    case ADMIN_DESCRIPTION_JA = 'プロジェクトの管理者です。';
    case MEMBER_DESCRIPTION_JA = 'プロジェクトのメンバーです。';
    case VIEWER_DESCRIPTION_JA = 'プロジェクトの閲覧者です。';
    case GUEST_DESCRIPTION_JA = 'プロジェクトのゲストです。';

    case OWNER_DESCRIPTION_EN = 'The owner of the project.';
    case ADMIN_DESCRIPTION_EN = 'The admin of the project.';
    case MEMBER_DESCRIPTION_EN = 'The member of the project.';
    case VIEWER_DESCRIPTION_EN = 'The viewer of the project.';
    case GUEST_DESCRIPTION_EN = 'The guest of the project.';

    public static function getJapaneseName(DefaultProjectRoleEnum $role): string
    {
        return match ($role) {
            DefaultProjectRoleEnum::OWNER => self::OWNER_NAME_JA->value,
            DefaultProjectRoleEnum::ADMIN => self::ADMIN_NAME_JA->value,
            DefaultProjectRoleEnum::MEMBER => self::MEMBER_NAME_JA->value,
            DefaultProjectRoleEnum::VIEWER => self::VIEWER_NAME_JA->value,
            DefaultProjectRoleEnum::GUEST => self::GUEST_NAME_JA->value,
        };
    }

    public static function getEnglishName(DefaultProjectRoleEnum $role): string
    {
        return match ($role) {
            DefaultProjectRoleEnum::OWNER => self::OWNER_NAME_EN->value,
            DefaultProjectRoleEnum::ADMIN => self::ADMIN_NAME_EN->value,
            DefaultProjectRoleEnum::MEMBER => self::MEMBER_NAME_EN->value,
            DefaultProjectRoleEnum::VIEWER => self::VIEWER_NAME_EN->value,
            DefaultProjectRoleEnum::GUEST => self::GUEST_NAME_EN->value,
        };
    }

    public static function getJapaneseDescription(DefaultProjectRoleEnum $role): string
    {
        return match ($role) {
            DefaultProjectRoleEnum::OWNER => self::OWNER_DESCRIPTION_JA->value,
            DefaultProjectRoleEnum::ADMIN => self::ADMIN_DESCRIPTION_JA->value,
            DefaultProjectRoleEnum::MEMBER => self::MEMBER_DESCRIPTION_JA->value,
            DefaultProjectRoleEnum::VIEWER => self::VIEWER_DESCRIPTION_JA->value,
            DefaultProjectRoleEnum::GUEST => self::GUEST_DESCRIPTION_JA->value,
        };
    }

    public static function getEnglishDescription(DefaultProjectRoleEnum $role): string
    {
        return match ($role) {
            DefaultProjectRoleEnum::OWNER => self::OWNER_DESCRIPTION_EN->value,
            DefaultProjectRoleEnum::ADMIN => self::ADMIN_DESCRIPTION_EN->value,
            DefaultProjectRoleEnum::MEMBER => self::MEMBER_DESCRIPTION_EN->value,
            DefaultProjectRoleEnum::VIEWER => self::VIEWER_DESCRIPTION_EN->value,
            DefaultProjectRoleEnum::GUEST => self::GUEST_DESCRIPTION_EN->value,
        };
    }

    public static function getName(DefaultProjectRoleEnum $role, LocaleEnum $locale): string
    {
        return match ($locale) {
            LocaleEnum::JAPANESE => self::getJapaneseName($role),
            LocaleEnum::ENGLISH => self::getEnglishName($role),
        };
    }

    public static function getDescription(DefaultProjectRoleEnum $role, LocaleEnum $locale): string
    {
        return match ($locale) {
            LocaleEnum::JAPANESE => self::getJapaneseDescription($role),
            LocaleEnum::ENGLISH => self::getEnglishDescription($role),
        };
    }
}
