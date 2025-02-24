<?php

namespace App\Enums;

enum PermissionTranslationEnum: string
{
    // Japanese
    case PROJECT_WILDCARD_JA = 'プロジェクト情報すべての権限';
    case PROJECT_READ_JA = 'プロジェクト閲覧';
    case PROJECT_UPDATE_JA = 'プロジェクト更新';
    case PROJECT_DELETE_JA = 'プロジェクト削除';

    case PROJECT_TASKS_WILDCARD_JA = 'タスク全ての権限';
    case PROJECT_TASKS_READ_JA = 'タスク閲覧';
    case PROJECT_TASKS_CREATE_JA = 'タスク作成';
    case PROJECT_TASKS_UPDATE_JA = 'タスク更新';
    case PROJECT_TASKS_DELETE_JA = 'タスク削除';

    case PROJECT_ROLES_WILDCARD_JA = 'ロール全ての権限';
    case PROJECT_ROLES_READ_JA = 'ロール閲覧';
    case PROJECT_ROLES_CREATE_JA = 'ロール作成';
    case PROJECT_ROLES_UPDATE_JA = 'ロール更新';
    case PROJECT_ROLES_DELETE_JA = 'ロール削除';

    case PROJECT_MEMBERS_WILDCARD_JA = 'メンバー全ての権限';
    case PROJECT_MEMBERS_READ_JA = 'メンバー閲覧';
    case PROJECT_MEMBERS_CREATE_JA = 'メンバー追加';
    case PROJECT_MEMBERS_UPDATE_JA = 'メンバー更新';
    case PROJECT_MEMBERS_DELETE_JA = 'メンバー削除';

    case PROJECT_INVITATIONS_WILDCARD_JA = '招待全ての権限';
    case PROJECT_INVITATIONS_READ_JA = '招待閲覧';
    case PROJECT_INVITATIONS_CREATE_JA = '招待作成';
    case PROJECT_INVITATIONS_UPDATE_JA = '招待更新';
    case PROJECT_INVITATIONS_DELETE_JA = '招待削除';

    // English
    case PROJECT_WILDCARD_EN = 'All Project Information Permissions';
    case PROJECT_READ_EN = 'View Project Information';
    case PROJECT_UPDATE_EN = 'Update Project Information';
    case PROJECT_DELETE_EN = 'Delete Project Information';

    case PROJECT_TASKS_WILDCARD_EN = 'All Task Permissions';
    case PROJECT_TASKS_READ_EN = 'View Tasks';
    case PROJECT_TASKS_CREATE_EN = 'Create Tasks';
    case PROJECT_TASKS_UPDATE_EN = 'Update Tasks';
    case PROJECT_TASKS_DELETE_EN = 'Delete Tasks';

    case PROJECT_ROLES_WILDCARD_EN = 'All Role Permissions';
    case PROJECT_ROLES_READ_EN = 'View Roles';
    case PROJECT_ROLES_CREATE_EN = 'Create Roles';
    case PROJECT_ROLES_UPDATE_EN = 'Update Roles';
    case PROJECT_ROLES_DELETE_EN = 'Delete Roles';

    case PROJECT_MEMBERS_WILDCARD_EN = 'All Member Permissions';
    case PROJECT_MEMBERS_READ_EN = 'View Members';
    case PROJECT_MEMBERS_CREATE_EN = 'Add Members';
    case PROJECT_MEMBERS_UPDATE_EN = 'Update Members';
    case PROJECT_MEMBERS_DELETE_EN = 'Remove Members';

    case PROJECT_INVITATIONS_WILDCARD_EN = 'All Invitation Permissions';
    case PROJECT_INVITATIONS_READ_EN = 'View Invitations';
    case PROJECT_INVITATIONS_CREATE_EN = 'Create Invitations';
    case PROJECT_INVITATIONS_UPDATE_EN = 'Update Invitations';
    case PROJECT_INVITATIONS_DELETE_EN = 'Delete Invitations';

    // Japanese description
    case PROJECT_WILDCARD_DESCRIPTION_JA = 'プロジェクト情報を閲覧、更新、削除できます。';
    case PROJECT_READ_DESCRIPTION_JA = 'プロジェクト情報を閲覧できます。';
    case PROJECT_UPDATE_DESCRIPTION_JA = 'プロジェクト情報を更新できます。';
    case PROJECT_DELETE_DESCRIPTION_JA = 'プロジェクト情報を削除できます。';
    case PROJECT_TASKS_WILDCARD_DESCRIPTION_JA = 'タスクを閲覧、更新、削除できます。';
    case PROJECT_TASKS_READ_DESCRIPTION_JA = 'タスクを閲覧できます。';
    case PROJECT_TASKS_CREATE_DESCRIPTION_JA = 'タスクを作成できます。';
    case PROJECT_TASKS_UPDATE_DESCRIPTION_JA = 'タスクを更新できます。';
    case PROJECT_TASKS_DELETE_DESCRIPTION_JA = 'タスクを削除できます。';
    case PROJECT_ROLES_WILDCARD_DESCRIPTION_JA = 'ロールを閲覧、更新、削除できます。';
    case PROJECT_ROLES_READ_DESCRIPTION_JA = 'ロールを閲覧できます。';
    case PROJECT_ROLES_CREATE_DESCRIPTION_JA = 'ロールを作成できます。';
    case PROJECT_ROLES_UPDATE_DESCRIPTION_JA = 'ロールを更新できます。';
    case PROJECT_ROLES_DELETE_DESCRIPTION_JA = 'ロールを削除できます。';
    case PROJECT_MEMBERS_WILDCARD_DESCRIPTION_JA = 'メンバーを閲覧、更新、削除できます。';
    case PROJECT_MEMBERS_READ_DESCRIPTION_JA = 'メンバーを閲覧できます。';
    case PROJECT_MEMBERS_CREATE_DESCRIPTION_JA = 'メンバーを作成できます。';
    case PROJECT_MEMBERS_UPDATE_DESCRIPTION_JA = 'メンバーを更新できます。';
    case PROJECT_MEMBERS_DELETE_DESCRIPTION_JA = 'メンバーを削除できます。';
    case PROJECT_INVITATIONS_WILDCARD_DESCRIPTION_JA = '招待を閲覧、更新、削除できます。';
    case PROJECT_INVITATIONS_READ_DESCRIPTION_JA = '招待を閲覧できます。';
    case PROJECT_INVITATIONS_CREATE_DESCRIPTION_JA = '招待を作成できます。';
    case PROJECT_INVITATIONS_UPDATE_DESCRIPTION_JA = '招待を更新できます。';
    case PROJECT_INVITATIONS_DELETE_DESCRIPTION_JA = '招待を削除できます。';

    // English description
    case PROJECT_WILDCARD_DESCRIPTION_EN = 'You can view, update, and delete project information.';
    case PROJECT_READ_DESCRIPTION_EN = 'You can view project information.';
    case PROJECT_UPDATE_DESCRIPTION_EN = 'You can update project information.';
    case PROJECT_DELETE_DESCRIPTION_EN = 'You can delete project information.';
    case PROJECT_TASKS_WILDCARD_DESCRIPTION_EN = 'You can view, update, and delete tasks.';
    case PROJECT_TASKS_READ_DESCRIPTION_EN = 'You can view tasks.';
    case PROJECT_TASKS_CREATE_DESCRIPTION_EN = 'You can create tasks.';
    case PROJECT_TASKS_UPDATE_DESCRIPTION_EN = 'You can update tasks.';
    case PROJECT_TASKS_DELETE_DESCRIPTION_EN = 'You can delete tasks.';
    case PROJECT_ROLES_WILDCARD_DESCRIPTION_EN = 'You can view, update, and delete roles.';
    case PROJECT_ROLES_READ_DESCRIPTION_EN = 'You can view roles.';
    case PROJECT_ROLES_CREATE_DESCRIPTION_EN = 'You can create roles.';
    case PROJECT_ROLES_UPDATE_DESCRIPTION_EN = 'You can update roles.';
    case PROJECT_ROLES_DELETE_DESCRIPTION_EN = 'You can delete roles.';
    case PROJECT_MEMBERS_WILDCARD_DESCRIPTION_EN = 'You can view, update, and delete members.';
    case PROJECT_MEMBERS_READ_DESCRIPTION_EN = 'You can view members.';
    case PROJECT_MEMBERS_CREATE_DESCRIPTION_EN = 'You can create members.';
    case PROJECT_MEMBERS_UPDATE_DESCRIPTION_EN = 'You can update members.';
    case PROJECT_MEMBERS_DELETE_DESCRIPTION_EN = 'You can delete members.';
    case PROJECT_INVITATIONS_WILDCARD_DESCRIPTION_EN = 'You can view, update, and delete invitations.';
    case PROJECT_INVITATIONS_READ_DESCRIPTION_EN = 'You can view invitations.';
    case PROJECT_INVITATIONS_CREATE_DESCRIPTION_EN = 'You can create invitations.';
    case PROJECT_INVITATIONS_UPDATE_DESCRIPTION_EN = 'You can update invitations.';
    case PROJECT_INVITATIONS_DELETE_DESCRIPTION_EN = 'You can delete invitations.';
    
    public static function getJapaneseName(PermissionEnum $permission): string
    {
        return match($permission) {
            PermissionEnum::PROJECT_WILDCARD => self::PROJECT_WILDCARD_JA->value,
            PermissionEnum::PROJECT_READ => self::PROJECT_READ_JA->value,
            PermissionEnum::PROJECT_UPDATE => self::PROJECT_UPDATE_JA->value,
            PermissionEnum::PROJECT_DELETE => self::PROJECT_DELETE_JA->value,
            PermissionEnum::PROJECT_TASKS_WILDCARD => self::PROJECT_TASKS_WILDCARD_JA->value,
            PermissionEnum::PROJECT_TASKS_READ => self::PROJECT_TASKS_READ_JA->value,
            PermissionEnum::PROJECT_TASKS_CREATE => self::PROJECT_TASKS_CREATE_JA->value,
            PermissionEnum::PROJECT_TASKS_UPDATE => self::PROJECT_TASKS_UPDATE_JA->value,
            PermissionEnum::PROJECT_TASKS_DELETE => self::PROJECT_TASKS_DELETE_JA->value,
            PermissionEnum::PROJECT_ROLES_WILDCARD => self::PROJECT_ROLES_WILDCARD_JA->value,
            PermissionEnum::PROJECT_ROLES_READ => self::PROJECT_ROLES_READ_JA->value,
            PermissionEnum::PROJECT_ROLES_CREATE => self::PROJECT_ROLES_CREATE_JA->value,
            PermissionEnum::PROJECT_ROLES_UPDATE => self::PROJECT_ROLES_UPDATE_JA->value,
            PermissionEnum::PROJECT_ROLES_DELETE => self::PROJECT_ROLES_DELETE_JA->value,
            PermissionEnum::PROJECT_MEMBERS_WILDCARD => self::PROJECT_MEMBERS_WILDCARD_JA->value,
            PermissionEnum::PROJECT_MEMBERS_READ => self::PROJECT_MEMBERS_READ_JA->value,
            PermissionEnum::PROJECT_MEMBERS_CREATE => self::PROJECT_MEMBERS_CREATE_JA->value,
            PermissionEnum::PROJECT_MEMBERS_UPDATE => self::PROJECT_MEMBERS_UPDATE_JA->value,
            PermissionEnum::PROJECT_MEMBERS_DELETE => self::PROJECT_MEMBERS_DELETE_JA->value,
            PermissionEnum::PROJECT_INVITATIONS_WILDCARD => self::PROJECT_INVITATIONS_WILDCARD_JA->value,
            PermissionEnum::PROJECT_INVITATIONS_READ => self::PROJECT_INVITATIONS_READ_JA->value,
            PermissionEnum::PROJECT_INVITATIONS_CREATE => self::PROJECT_INVITATIONS_CREATE_JA->value,
            PermissionEnum::PROJECT_INVITATIONS_UPDATE => self::PROJECT_INVITATIONS_UPDATE_JA->value,
            PermissionEnum::PROJECT_INVITATIONS_DELETE => self::PROJECT_INVITATIONS_DELETE_JA->value,
        };
    }

    public static function getEnglishName(PermissionEnum $permission): string
    {
        return match($permission) {
            PermissionEnum::PROJECT_WILDCARD => self::PROJECT_WILDCARD_EN->value,
            PermissionEnum::PROJECT_READ => self::PROJECT_READ_EN->value,
            PermissionEnum::PROJECT_UPDATE => self::PROJECT_UPDATE_EN->value,
            PermissionEnum::PROJECT_DELETE => self::PROJECT_DELETE_EN->value,
            PermissionEnum::PROJECT_TASKS_WILDCARD => self::PROJECT_TASKS_WILDCARD_EN->value,
            PermissionEnum::PROJECT_TASKS_READ => self::PROJECT_TASKS_READ_EN->value,
            PermissionEnum::PROJECT_TASKS_CREATE => self::PROJECT_TASKS_CREATE_EN->value,
            PermissionEnum::PROJECT_TASKS_UPDATE => self::PROJECT_TASKS_UPDATE_EN->value,
            PermissionEnum::PROJECT_TASKS_DELETE => self::PROJECT_TASKS_DELETE_EN->value,
            PermissionEnum::PROJECT_ROLES_WILDCARD => self::PROJECT_ROLES_WILDCARD_EN->value,
            PermissionEnum::PROJECT_ROLES_READ => self::PROJECT_ROLES_READ_EN->value,
            PermissionEnum::PROJECT_ROLES_CREATE => self::PROJECT_ROLES_CREATE_EN->value,
            PermissionEnum::PROJECT_ROLES_UPDATE => self::PROJECT_ROLES_UPDATE_EN->value,
            PermissionEnum::PROJECT_ROLES_DELETE => self::PROJECT_ROLES_DELETE_EN->value,
            PermissionEnum::PROJECT_MEMBERS_WILDCARD => self::PROJECT_MEMBERS_WILDCARD_EN->value,
            PermissionEnum::PROJECT_MEMBERS_READ => self::PROJECT_MEMBERS_READ_EN->value,
            PermissionEnum::PROJECT_MEMBERS_CREATE => self::PROJECT_MEMBERS_CREATE_EN->value,
            PermissionEnum::PROJECT_MEMBERS_UPDATE => self::PROJECT_MEMBERS_UPDATE_EN->value,
            PermissionEnum::PROJECT_MEMBERS_DELETE => self::PROJECT_MEMBERS_DELETE_EN->value,
            PermissionEnum::PROJECT_INVITATIONS_WILDCARD => self::PROJECT_INVITATIONS_WILDCARD_EN->value,
            PermissionEnum::PROJECT_INVITATIONS_READ => self::PROJECT_INVITATIONS_READ_EN->value,
            PermissionEnum::PROJECT_INVITATIONS_CREATE => self::PROJECT_INVITATIONS_CREATE_EN->value,
            PermissionEnum::PROJECT_INVITATIONS_UPDATE => self::PROJECT_INVITATIONS_UPDATE_EN->value,
            PermissionEnum::PROJECT_INVITATIONS_DELETE => self::PROJECT_INVITATIONS_DELETE_EN->value,
        };
    }

    public static function getJapaneseDescription(PermissionEnum $permission): string
    {
        return match($permission) {
            PermissionEnum::PROJECT_WILDCARD => self::PROJECT_WILDCARD_JA->value,
            PermissionEnum::PROJECT_READ => self::PROJECT_READ_DESCRIPTION_JA->value,
            PermissionEnum::PROJECT_UPDATE => self::PROJECT_UPDATE_DESCRIPTION_JA->value,
            PermissionEnum::PROJECT_DELETE => self::PROJECT_DELETE_DESCRIPTION_JA->value,
            PermissionEnum::PROJECT_TASKS_WILDCARD => self::PROJECT_TASKS_WILDCARD_DESCRIPTION_JA->value,
            PermissionEnum::PROJECT_TASKS_READ => self::PROJECT_TASKS_READ_DESCRIPTION_JA->value,
            PermissionEnum::PROJECT_TASKS_CREATE => self::PROJECT_TASKS_CREATE_DESCRIPTION_JA->value,
            PermissionEnum::PROJECT_TASKS_UPDATE => self::PROJECT_TASKS_UPDATE_DESCRIPTION_JA->value,
            PermissionEnum::PROJECT_TASKS_DELETE => self::PROJECT_TASKS_DELETE_DESCRIPTION_JA->value,
            PermissionEnum::PROJECT_ROLES_WILDCARD => self::PROJECT_ROLES_WILDCARD_DESCRIPTION_JA->value,
            PermissionEnum::PROJECT_ROLES_READ => self::PROJECT_ROLES_READ_DESCRIPTION_JA->value,
            PermissionEnum::PROJECT_ROLES_CREATE => self::PROJECT_ROLES_CREATE_DESCRIPTION_JA->value,
            PermissionEnum::PROJECT_ROLES_UPDATE => self::PROJECT_ROLES_UPDATE_DESCRIPTION_JA->value,
            PermissionEnum::PROJECT_ROLES_DELETE => self::PROJECT_ROLES_DELETE_DESCRIPTION_JA->value,
            PermissionEnum::PROJECT_MEMBERS_WILDCARD => self::PROJECT_MEMBERS_WILDCARD_DESCRIPTION_JA->value,
            PermissionEnum::PROJECT_MEMBERS_READ => self::PROJECT_MEMBERS_READ_DESCRIPTION_JA->value,
            PermissionEnum::PROJECT_MEMBERS_CREATE => self::PROJECT_MEMBERS_CREATE_DESCRIPTION_JA->value,
            PermissionEnum::PROJECT_MEMBERS_UPDATE => self::PROJECT_MEMBERS_UPDATE_DESCRIPTION_JA->value,
            PermissionEnum::PROJECT_MEMBERS_DELETE => self::PROJECT_MEMBERS_DELETE_DESCRIPTION_JA->value,
            PermissionEnum::PROJECT_INVITATIONS_WILDCARD => self::PROJECT_INVITATIONS_WILDCARD_DESCRIPTION_JA->value,
            PermissionEnum::PROJECT_INVITATIONS_READ => self::PROJECT_INVITATIONS_READ_DESCRIPTION_JA->value,
            PermissionEnum::PROJECT_INVITATIONS_CREATE => self::PROJECT_INVITATIONS_CREATE_DESCRIPTION_JA->value,
            PermissionEnum::PROJECT_INVITATIONS_UPDATE => self::PROJECT_INVITATIONS_UPDATE_DESCRIPTION_JA->value,
            PermissionEnum::PROJECT_INVITATIONS_DELETE => self::PROJECT_INVITATIONS_DELETE_DESCRIPTION_JA->value,
        };
    }

    public static function getEnglishDescription(PermissionEnum $permission): string
    {
        return match($permission) {
            PermissionEnum::PROJECT_WILDCARD => self::PROJECT_WILDCARD_DESCRIPTION_EN->value,
            PermissionEnum::PROJECT_READ => self::PROJECT_READ_DESCRIPTION_EN->value,
            PermissionEnum::PROJECT_UPDATE => self::PROJECT_UPDATE_DESCRIPTION_EN->value,
            PermissionEnum::PROJECT_DELETE => self::PROJECT_DELETE_DESCRIPTION_EN->value,
            PermissionEnum::PROJECT_TASKS_WILDCARD => self::PROJECT_TASKS_WILDCARD_DESCRIPTION_EN->value,
            PermissionEnum::PROJECT_TASKS_READ => self::PROJECT_TASKS_READ_DESCRIPTION_EN->value,
            PermissionEnum::PROJECT_TASKS_CREATE => self::PROJECT_TASKS_CREATE_DESCRIPTION_EN->value,
            PermissionEnum::PROJECT_TASKS_UPDATE => self::PROJECT_TASKS_UPDATE_DESCRIPTION_EN->value,
            PermissionEnum::PROJECT_TASKS_DELETE => self::PROJECT_TASKS_DELETE_DESCRIPTION_EN->value,
            PermissionEnum::PROJECT_ROLES_WILDCARD => self::PROJECT_ROLES_WILDCARD_DESCRIPTION_EN->value,
            PermissionEnum::PROJECT_ROLES_READ => self::PROJECT_ROLES_READ_DESCRIPTION_EN->value,
            PermissionEnum::PROJECT_ROLES_CREATE => self::PROJECT_ROLES_CREATE_DESCRIPTION_EN->value,
            PermissionEnum::PROJECT_ROLES_UPDATE => self::PROJECT_ROLES_UPDATE_DESCRIPTION_EN->value,
            PermissionEnum::PROJECT_ROLES_DELETE => self::PROJECT_ROLES_DELETE_DESCRIPTION_EN->value,
            PermissionEnum::PROJECT_MEMBERS_WILDCARD => self::PROJECT_MEMBERS_WILDCARD_DESCRIPTION_EN->value,
            PermissionEnum::PROJECT_MEMBERS_READ => self::PROJECT_MEMBERS_READ_DESCRIPTION_EN->value,
            PermissionEnum::PROJECT_MEMBERS_CREATE => self::PROJECT_MEMBERS_CREATE_DESCRIPTION_EN->value,
            PermissionEnum::PROJECT_MEMBERS_UPDATE => self::PROJECT_MEMBERS_UPDATE_DESCRIPTION_EN->value,
            PermissionEnum::PROJECT_MEMBERS_DELETE => self::PROJECT_MEMBERS_DELETE_DESCRIPTION_EN->value,
            PermissionEnum::PROJECT_INVITATIONS_WILDCARD => self::PROJECT_INVITATIONS_WILDCARD_DESCRIPTION_EN->value,
            PermissionEnum::PROJECT_INVITATIONS_READ => self::PROJECT_INVITATIONS_READ_DESCRIPTION_EN->value,
            PermissionEnum::PROJECT_INVITATIONS_CREATE => self::PROJECT_INVITATIONS_CREATE_DESCRIPTION_EN->value,
            PermissionEnum::PROJECT_INVITATIONS_UPDATE => self::PROJECT_INVITATIONS_UPDATE_DESCRIPTION_EN->value,
            PermissionEnum::PROJECT_INVITATIONS_DELETE => self::PROJECT_INVITATIONS_DELETE_DESCRIPTION_EN->value,
        };
    }
    

    public static function getName(PermissionEnum $permission, LocaleEnum $locale): string
    {
        return match($locale) {
            LocaleEnum::JAPANESE => self::getJapaneseName($permission),
            LocaleEnum::ENGLISH => self::getEnglishName($permission),
        };
    }

    public static function getDescription(PermissionEnum $permission, LocaleEnum $locale): string
    {
        return match($locale) {
            LocaleEnum::JAPANESE => self::getJapaneseDescription($permission),
            LocaleEnum::ENGLISH => self::getEnglishDescription($permission),
        };
    }
} 
