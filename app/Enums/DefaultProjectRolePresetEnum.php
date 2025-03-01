<?php

namespace App\Enums;

enum DefaultProjectRolePresetEnum: int
{
    case OWNER = 1;
    case ADMIN = 2;
    case MEMBER = 3;
    case VIEWER = 4;
    case GUEST = 5;

    case OWNER_PERMISSIONS = [
        'projects:*',
        'projects:tasks:*',
        'projects:roles:*',
        'projects:members:*',
        'projects:invitations:*'
    ];

    case ADMIN_PERMISSIONS = [
        'projects:read',
        'projects:update',
        'projects:tasks:*',
        'projects:roles:*',
        'projects:members:*',
        'projects:invitations:*'
    ];

    case MEMBER_PERMISSIONS = [
        'projects:read',
        'projects:tasks:read',
        'projects:tasks:create',
        'projects:tasks:update',
        'projects:members:read',
        'projects:invitations:read'
    ];

    case VIEWER_PERMISSIONS = [
        'projects:read',
        'projects:tasks:read',
        'projects:members:read'
    ];

    case GUEST_PERMISSIONS = [
        'projects:read',
        'projects:tasks:read'
    ];

    case OWNER_NAME_JP = 'オーナー';
    case ADMIN_NAME_JP = '管理者';
    case MEMBER_NAME_JP = 'メンバー';
    case VIEWER_NAME_JP = '閲覧者';
    case GUEST_NAME_JP = 'ゲスト';

    case OWNER_NAME_EN = 'Owner';
    case ADMIN_NAME_EN = 'Admin';
    case MEMBER_NAME_EN = 'Member';
    case VIEWER_NAME_EN = 'Viewer';
    case GUEST_NAME_EN = 'Guest';

    case OWNER_DESCRIPTION_JP = 'プロジェクトの全ての権限を持つオーナー';
    case ADMIN_DESCRIPTION_JP = 'プロジェクトの管理権限を持つ管理者';
    case MEMBER_DESCRIPTION_JP = 'プロジェクトの基本的な操作が可能なメンバー';
    case VIEWER_DESCRIPTION_JP = 'プロジェクトの閲覧のみ可能な閲覧者';
    case GUEST_DESCRIPTION_JP = '限定的な閲覧のみ可能なゲスト';

    case OWNER_DESCRIPTION_EN = 'The owner of the project has all permissions';
    case ADMIN_DESCRIPTION_EN = 'The admin of the project has all permissions';
    case MEMBER_DESCRIPTION_EN = 'The member of the project has all permissions';
    case VIEWER_DESCRIPTION_EN = 'The viewer of the project has all permissions';
    case GUEST_DESCRIPTION_EN = 'The guest of the project has all permissions';

    /**
     * デフォルトロールの日本語名を取得
     */
    public static function getJapaneseName(self $role): string
    {
        return match($role) {
            self::OWNER => self::OWNER_NAME_JP->value,
            self::ADMIN => self::ADMIN_NAME_JP->value,
            self::MEMBER => self::MEMBER_NAME_JP->value, 
            self::VIEWER => self::VIEWER_NAME_JP->value,
            self::GUEST => self::GUEST_NAME_JP->value,
        };
    }

    /**
     * デフォルトロールの日本語説明を取得
     */
    public static function getJapaneseDescription(self $role): string
    {
        return match($role) {
            self::OWNER => self::OWNER_DESCRIPTION_JP->value,
            self::ADMIN => self::ADMIN_DESCRIPTION_JP->value,
            self::MEMBER => self::MEMBER_DESCRIPTION_JP->value,
            self::VIEWER => self::VIEWER_DESCRIPTION_JP->value,
            self::GUEST => self::GUEST_DESCRIPTION_JP->value,
        };
    }

    /**
     * デフォルトロールの英語名を取得
     */
    public static function getEnglishName(self $role): string
    {
        return match($role) {
            self::OWNER => self::OWNER_NAME_EN->value,
            self::ADMIN => self::ADMIN_NAME_EN->value,
            self::MEMBER => self::MEMBER_NAME_EN->value,
            self::VIEWER => self::VIEWER_NAME_EN->value,
            self::GUEST => self::GUEST_NAME_EN->value,
        };
    }

    /**
     * デフォルトロールの英語説明を取得
     */
    public static function getEnglishDescription(self $role): string
    {
        return match($role) {
            self::OWNER => self::OWNER_DESCRIPTION_EN->value,
            self::ADMIN => self::ADMIN_DESCRIPTION_EN->value,
            self::MEMBER => self::MEMBER_DESCRIPTION_EN->value,
            self::VIEWER => self::VIEWER_DESCRIPTION_EN->value,
            self::GUEST => self::GUEST_DESCRIPTION_EN->value,
        };
    }

    /**
     * デフォルトロールの名前を取得
     */
    public static function getName(self $role, LocaleEnum $locale): string
    {
        return match($locale) {
            LocaleEnum::JAPANESE => self::getJapaneseName($role),
            LocaleEnum::ENGLISH => self::getEnglishName($role),
        };
    }

    public static function getDescription(self $role, LocaleEnum $locale): string
    {
        return match($locale) {
            LocaleEnum::JAPANESE => self::getJapaneseDescription($role),
            LocaleEnum::ENGLISH => self::getEnglishDescription($role),
        };
    }
} 