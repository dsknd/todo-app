<?php

namespace App\Enums;

enum DefaultProjectRolePresetEnum: int
{
    case OWNER = 1;
    case ADMIN = 2;
    case MEMBER = 3;
    case VIEWER = 4;
    case GUEST = 5;

    private const OWNER_PERMISSIONS = [
        ProjectPermissionEnum::PROJECT_WILDCARD,
        ProjectPermissionEnum::PROJECT_TASK_WILDCARD,
        ProjectPermissionEnum::PROJECT_ROLE_WILDCARD,
        ProjectPermissionEnum::PROJECT_MEMBER_WILDCARD,
        ProjectPermissionEnum::PROJECT_INVITATION_WILDCARD,
    ];

    private const ADMIN_PERMISSIONS = [
        ProjectPermissionEnum::PROJECT_READ,
        ProjectPermissionEnum::PROJECT_UPDATE,
        ProjectPermissionEnum::PROJECT_TASK_WILDCARD,
        ProjectPermissionEnum::PROJECT_ROLE_WILDCARD,
        ProjectPermissionEnum::PROJECT_MEMBER_WILDCARD,
        ProjectPermissionEnum::PROJECT_INVITATION_WILDCARD,
    ];

    private const MEMBER_PERMISSIONS = [
        ProjectPermissionEnum::PROJECT_READ,
        ProjectPermissionEnum::PROJECT_TASK_READ,
        ProjectPermissionEnum::PROJECT_TASK_CREATE,
        ProjectPermissionEnum::PROJECT_TASK_UPDATE,
        ProjectPermissionEnum::PROJECT_MEMBER_READ,
        ProjectPermissionEnum::PROJECT_INVITATION_READ,
    ];

    private const VIEWER_PERMISSIONS = [
        ProjectPermissionEnum::PROJECT_READ,
        ProjectPermissionEnum::PROJECT_TASK_READ,
        ProjectPermissionEnum::PROJECT_MEMBER_READ,
    ];

    private const GUEST_PERMISSIONS = [
        ProjectPermissionEnum::PROJECT_READ,
        ProjectPermissionEnum::PROJECT_TASK_READ,
    ];

    private const OWNER_NAME_JP = 'オーナー';
    private const ADMIN_NAME_JP = '管理者';
    private const MEMBER_NAME_JP = 'メンバー';
    private const VIEWER_NAME_JP = '閲覧者';
    private const GUEST_NAME_JP = 'ゲスト';

    private const OWNER_NAME_EN = 'Owner';
    private const ADMIN_NAME_EN = 'Admin';
    private const MEMBER_NAME_EN = 'Member';
    private const VIEWER_NAME_EN = 'Viewer';
    private const GUEST_NAME_EN = 'Guest';

    private const OWNER_DESCRIPTION_JP = 'プロジェクトの全ての権限を持つオーナー';
    private const ADMIN_DESCRIPTION_JP = 'プロジェクトの管理権限を持つ管理者';
    private const MEMBER_DESCRIPTION_JP = 'プロジェクトの基本的な操作が可能なメンバー';
    private const VIEWER_DESCRIPTION_JP = 'プロジェクトの閲覧のみ可能な閲覧者';
    private const GUEST_DESCRIPTION_JP = '限定的な閲覧のみ可能なゲスト';

    private const OWNER_DESCRIPTION_EN = 'The owner of the project has all permissions';
    private const ADMIN_DESCRIPTION_EN = 'The admin of the project has all permissions';
    private const MEMBER_DESCRIPTION_EN = 'The member of the project has all permissions';
    private const VIEWER_DESCRIPTION_EN = 'The viewer of the project has all permissions';
    private const GUEST_DESCRIPTION_EN = 'The guest of the project has all permissions';

    /**
     * デフォルトロールの日本語名を取得
     */
    public static function getJapaneseName(self $role): string
    {
        return match($role) {
            self::OWNER => self::OWNER_NAME_JP,
            self::ADMIN => self::ADMIN_NAME_JP,
            self::MEMBER => self::MEMBER_NAME_JP, 
            self::VIEWER => self::VIEWER_NAME_JP,
            self::GUEST => self::GUEST_NAME_JP,
        };
    }

    /**
     * デフォルトロールの日本語説明を取得
     */
    public static function getJapaneseDescription(self $role): string
    {
        return match($role) {
            self::OWNER => self::OWNER_DESCRIPTION_JP,
            self::ADMIN => self::ADMIN_DESCRIPTION_JP,
            self::MEMBER => self::MEMBER_DESCRIPTION_JP,
            self::VIEWER => self::VIEWER_DESCRIPTION_JP,
            self::GUEST => self::GUEST_DESCRIPTION_JP,
        };
    }

    /**
     * デフォルトロールの英語名を取得
     */
    public static function getEnglishName(self $role): string
    {
        return match($role) {
            self::OWNER => self::OWNER_NAME_EN,
            self::ADMIN => self::ADMIN_NAME_EN,
            self::MEMBER => self::MEMBER_NAME_EN,
            self::VIEWER => self::VIEWER_NAME_EN,
            self::GUEST => self::GUEST_NAME_EN,
        };
    }

    /**
     * デフォルトロールの英語説明を取得
     */
    public static function getEnglishDescription(self $role): string
    {
        return match($role) {
            self::OWNER => self::OWNER_DESCRIPTION_EN,
            self::ADMIN => self::ADMIN_DESCRIPTION_EN,
            self::MEMBER => self::MEMBER_DESCRIPTION_EN,
            self::VIEWER => self::VIEWER_DESCRIPTION_EN,
            self::GUEST => self::GUEST_DESCRIPTION_EN,
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

    public static function getPermissions(self $role): array
    {
        return match($role) {
            self::OWNER => self::OWNER_PERMISSIONS,
            self::ADMIN => self::ADMIN_PERMISSIONS,
            self::MEMBER => self::MEMBER_PERMISSIONS,
            self::VIEWER => self::VIEWER_PERMISSIONS,
            self::GUEST => self::GUEST_PERMISSIONS,
        };
    }
} 