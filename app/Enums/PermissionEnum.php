<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static PROJECT_WILDCARD()
 * @method static static PROJECT_READ()
 * @method static static PROJECT_UPDATE()
 * @method static static PROJECT_DELETE()
 * @method static static PROJECT_TASKS_WILDCARD()
 * @method static static PROJECT_TASKS_READ()
 * @method static static PROJECT_TASKS_CREATE()
 * @method static static PROJECT_TASKS_UPDATE()
 * @method static static PROJECT_TASKS_DELETE()
 * @method static static PROJECT_ROLES_WILDCARD()
 * @method static static PROJECT_ROLES_READ()
 * @method static static PROJECT_ROLES_CREATE()
 * @method static static PROJECT_ROLES_UPDATE()
 * @method static static PROJECT_ROLES_DELETE()
 * @method static static PROJECT_MEMBERS_WILDCARD()
 * @method static static PROJECT_MEMBERS_READ()
 * @method static static PROJECT_MEMBERS_CREATE()
 * @method static static PROJECT_MEMBERS_UPDATE()
 * @method static static PROJECT_MEMBERS_DELETE()
 * @method static static PROJECT_INVITATIONS_WILDCARD()
 * @method static static PROJECT_INVITATIONS_READ()
 * @method static static PROJECT_INVITATIONS_CREATE()
 * @method static static PROJECT_INVITATIONS_UPDATE()
 * @method static static PROJECT_INVITATIONS_DELETE()
 */
enum PermissionEnum: int
{
    case PROJECT_WILDCARD = 1;
    case PROJECT_READ = 2;
    case PROJECT_UPDATE = 3;
    case PROJECT_DELETE = 4;

    case PROJECT_TASKS_WILDCARD = 5;
    case PROJECT_TASKS_READ = 6;
    case PROJECT_TASKS_CREATE = 7;
    case PROJECT_TASKS_UPDATE = 8;
    case PROJECT_TASKS_DELETE = 9;

    case PROJECT_ROLES_WILDCARD = 10;
    case PROJECT_ROLES_READ = 11;
    case PROJECT_ROLES_CREATE = 12;
    case PROJECT_ROLES_UPDATE = 13;
    case PROJECT_ROLES_DELETE = 14;

    case PROJECT_MEMBERS_WILDCARD = 15;
    case PROJECT_MEMBERS_READ = 16;
    case PROJECT_MEMBERS_CREATE = 17;
    case PROJECT_MEMBERS_UPDATE = 18;
    case PROJECT_MEMBERS_DELETE = 19;
    
    case PROJECT_INVITATIONS_WILDCARD = 20;
    case PROJECT_INVITATIONS_READ = 21;
    case PROJECT_INVITATIONS_CREATE = 22;
    case PROJECT_INVITATIONS_UPDATE = 23;
    case PROJECT_INVITATIONS_DELETE = 24;

    public static function getScope(mixed $value): string
    {
        if (is_int($value)) {
            $value = self::from($value);
        }

        return match($value) {
            self::PROJECT_WILDCARD => 'projects:*',
            self::PROJECT_READ => 'projects:read',
            self::PROJECT_UPDATE => 'projects:update',
            self::PROJECT_DELETE => 'projects:delete',

            self::PROJECT_TASKS_WILDCARD => 'projects:tasks:*',
            self::PROJECT_TASKS_READ => 'projects:tasks:read',
            self::PROJECT_TASKS_CREATE => 'projects:tasks:create',
            self::PROJECT_TASKS_UPDATE => 'projects:tasks:update',
            self::PROJECT_TASKS_DELETE => 'projects:tasks:delete',

            self::PROJECT_ROLES_WILDCARD => 'projects:roles:*',
            self::PROJECT_ROLES_READ => 'projects:roles:read',
            self::PROJECT_ROLES_CREATE => 'projects:roles:create',
            self::PROJECT_ROLES_UPDATE => 'projects:roles:update',
            self::PROJECT_ROLES_DELETE => 'projects:roles:delete',

            self::PROJECT_MEMBERS_WILDCARD => 'projects:members:*',
            self::PROJECT_MEMBERS_READ => 'projects:members:read',
            self::PROJECT_MEMBERS_CREATE => 'projects:members:create',
            self::PROJECT_MEMBERS_UPDATE => 'projects:members:update',
            self::PROJECT_MEMBERS_DELETE => 'projects:members:delete',

            self::PROJECT_INVITATIONS_WILDCARD => 'projects:invitations:*',
            self::PROJECT_INVITATIONS_READ => 'projects:invitations:read',
            self::PROJECT_INVITATIONS_CREATE => 'projects:invitations:create',
            self::PROJECT_INVITATIONS_UPDATE => 'projects:invitations:update',
            self::PROJECT_INVITATIONS_DELETE => 'projects:invitations:delete',
        };
    }

    public static function getAction(mixed $value): string
    {
        if (is_int($value)) {
            $value = self::from($value);
        }

        return match($value) {
            self::PROJECT_WILDCARD => '*',
            self::PROJECT_READ => 'read',
            self::PROJECT_UPDATE => 'update',
            self::PROJECT_DELETE => 'delete',

            self::PROJECT_TASKS_WILDCARD => '*',
            self::PROJECT_TASKS_READ => 'read',
            self::PROJECT_TASKS_CREATE => 'create',
            self::PROJECT_TASKS_UPDATE => 'update',
            self::PROJECT_TASKS_DELETE => 'delete',

            self::PROJECT_ROLES_WILDCARD => '*',
            self::PROJECT_ROLES_READ => 'read',
            self::PROJECT_ROLES_CREATE => 'create',
            self::PROJECT_ROLES_UPDATE => 'update',
            self::PROJECT_ROLES_DELETE => 'delete',

            self::PROJECT_MEMBERS_WILDCARD => '*',
            self::PROJECT_MEMBERS_READ => 'read',
            self::PROJECT_MEMBERS_CREATE => 'create',
            self::PROJECT_MEMBERS_UPDATE => 'update',
            self::PROJECT_MEMBERS_DELETE => 'delete',

            self::PROJECT_INVITATIONS_WILDCARD => '*',
            self::PROJECT_INVITATIONS_READ => 'read',
            self::PROJECT_INVITATIONS_CREATE => 'create',
            self::PROJECT_INVITATIONS_UPDATE => 'update',
            self::PROJECT_INVITATIONS_DELETE => 'delete',
        };
    }

    public static function getResource(mixed $value): string
    {
        if (is_int($value)) {
            $value = self::from($value);
        }

        return match($value) {
            self::PROJECT_WILDCARD,
            self::PROJECT_READ,
            self::PROJECT_UPDATE,
            self::PROJECT_DELETE => 'projects',

            self::PROJECT_TASKS_WILDCARD,
            self::PROJECT_TASKS_READ,
            self::PROJECT_TASKS_CREATE,
            self::PROJECT_TASKS_UPDATE,
            self::PROJECT_TASKS_DELETE => 'projects.tasks',

            self::PROJECT_ROLES_WILDCARD,
            self::PROJECT_ROLES_READ,
            self::PROJECT_ROLES_CREATE,
            self::PROJECT_ROLES_UPDATE,
            self::PROJECT_ROLES_DELETE => 'projects.roles',

            self::PROJECT_MEMBERS_WILDCARD,
            self::PROJECT_MEMBERS_READ,
            self::PROJECT_MEMBERS_CREATE,
            self::PROJECT_MEMBERS_UPDATE,
            self::PROJECT_MEMBERS_DELETE => 'projects.members',

            self::PROJECT_INVITATIONS_WILDCARD,
            self::PROJECT_INVITATIONS_READ,
            self::PROJECT_INVITATIONS_CREATE,
            self::PROJECT_INVITATIONS_UPDATE,
            self::PROJECT_INVITATIONS_DELETE => 'projects.invitations',
        };
    }

    public static function getDisplayName(mixed $value): string
    {
        if (is_int($value)) {
            $value = self::from($value);
        }

        return match($value) {
            self::PROJECT_WILDCARD => 'プロジェクト全ての権限',
            self::PROJECT_READ => 'プロジェクト読み取り権限',
            self::PROJECT_UPDATE => 'プロジェクト更新権限',
            self::PROJECT_DELETE => 'プロジェクト削除権限',

            self::PROJECT_TASKS_WILDCARD => 'プロジェクトタスク全ての権限',
            self::PROJECT_TASKS_READ => 'プロジェクトタスク読み取り権限',
            self::PROJECT_TASKS_CREATE => 'プロジェクトタスク作成権限',
            self::PROJECT_TASKS_UPDATE => 'プロジェクトタスク更新権限',
            self::PROJECT_TASKS_DELETE => 'プロジェクトタスク削除権限',

            self::PROJECT_ROLES_WILDCARD => 'プロジェクトロール全ての権限',
            self::PROJECT_ROLES_READ => 'プロジェクトロール読み取り権限',
            self::PROJECT_ROLES_CREATE => 'プロジェクトロール作成権限',
            self::PROJECT_ROLES_UPDATE => 'プロジェクトロール更新権限',
            self::PROJECT_ROLES_DELETE => 'プロジェクトロール削除権限',

            self::PROJECT_MEMBERS_WILDCARD => 'プロジェクトメンバー全ての権限',
            self::PROJECT_MEMBERS_READ => 'プロジェクトメンバー読み取り権限',
            self::PROJECT_MEMBERS_CREATE => 'プロジェクトメンバー作成権限',
            self::PROJECT_MEMBERS_UPDATE => 'プロジェクトメンバー更新権限',
            self::PROJECT_MEMBERS_DELETE => 'プロジェクトメンバー削除権限',

            self::PROJECT_INVITATIONS_WILDCARD => 'プロジェクト招待全ての権限',
            self::PROJECT_INVITATIONS_READ => 'プロジェクト招待読み取り権限',
            self::PROJECT_INVITATIONS_CREATE => 'プロジェクト招待作成権限',
            self::PROJECT_INVITATIONS_UPDATE => 'プロジェクト招待更新権限',
            self::PROJECT_INVITATIONS_DELETE => 'プロジェクト招待削除権限',
        };
    }

    public static function getDescription(mixed $value): string
    {
        if (is_int($value)) {
            $value = self::from($value);
        }

        return match($value) {
            self::PROJECT_WILDCARD => 'プロジェクトリソースのすべての操作が可能です。',
            self::PROJECT_READ => 'プロジェクトリソースの読み取りが可能です。',
            self::PROJECT_UPDATE => 'プロジェクトリソースの更新が可能です。',
            self::PROJECT_DELETE => 'プロジェクトリソースの削除が可能です。',

            self::PROJECT_TASKS_WILDCARD => 'プロジェクトタスクリソースのすべての操作が可能です。',
            self::PROJECT_TASKS_READ => 'プロジェクトタスクリソースの読み取りが可能です。',
            self::PROJECT_TASKS_CREATE => 'プロジェクトタスクリソースの作成が可能です。',
            self::PROJECT_TASKS_UPDATE => 'プロジェクトタスクリソースの更新が可能です。',
            self::PROJECT_TASKS_DELETE => 'プロジェクトタスクリソースの削除が可能です。',

            self::PROJECT_ROLES_WILDCARD => 'プロジェクトロールリソースのすべての操作が可能です。',
            self::PROJECT_ROLES_READ => 'プロジェクトロールリソースの読み取りが可能です。',
            self::PROJECT_ROLES_CREATE => 'プロジェクトロールリソースの作成が可能です。',
            self::PROJECT_ROLES_UPDATE => 'プロジェクトロールリソースの更新が可能です。',
            self::PROJECT_ROLES_DELETE => 'プロジェクトロールリソースの削除が可能です。',

            self::PROJECT_MEMBERS_WILDCARD => 'プロジェクトメンバーリソースのすべての操作が可能です。',
            self::PROJECT_MEMBERS_READ => 'プロジェクトメンバーリソースの読み取りが可能です。',
            self::PROJECT_MEMBERS_CREATE => 'プロジェクトメンバーリソースの作成が可能です。',
            self::PROJECT_MEMBERS_UPDATE => 'プロジェクトメンバーリソースの更新が可能です。',
            self::PROJECT_MEMBERS_DELETE => 'プロジェクトメンバーリソースの削除が可能です。',

            self::PROJECT_INVITATIONS_WILDCARD => 'プロジェクト招待リソースのすべての操作が可能です。',
            self::PROJECT_INVITATIONS_READ => 'プロジェクト招待リソースの読み取りが可能です。',
            self::PROJECT_INVITATIONS_CREATE => 'プロジェクト招待リソースの作成が可能です。',
            self::PROJECT_INVITATIONS_UPDATE => 'プロジェクト招待リソースの更新が可能です。',
            self::PROJECT_INVITATIONS_DELETE => 'プロジェクト招待リソースの削除が可能です。',
        };
    }

    // 権限の階層を定義する
    public static function getHierarchy(mixed $value): array
    {
        if (!$value) {
            return [];
        }

        if (is_int($value)) {
            try {
                $value = self::from($value);
            } catch (\ValueError $e) {
                return [];
            }
        }

        return match($value) {
            self::PROJECT_WILDCARD => [
                self::PROJECT_READ,
                self::PROJECT_UPDATE,
                self::PROJECT_DELETE,
            ],
            self::PROJECT_TASKS_WILDCARD => [
                self::PROJECT_TASKS_READ,
                self::PROJECT_TASKS_CREATE,
                self::PROJECT_TASKS_UPDATE,
                self::PROJECT_TASKS_DELETE,
            ],
            self::PROJECT_ROLES_WILDCARD => [
                self::PROJECT_ROLES_READ,
                self::PROJECT_ROLES_CREATE,
                self::PROJECT_ROLES_UPDATE,
                self::PROJECT_ROLES_DELETE,
            ],
            self::PROJECT_MEMBERS_WILDCARD => [
                self::PROJECT_MEMBERS_READ,
                self::PROJECT_MEMBERS_CREATE,
                self::PROJECT_MEMBERS_UPDATE,
                self::PROJECT_MEMBERS_DELETE,
            ],
            self::PROJECT_INVITATIONS_WILDCARD => [
                self::PROJECT_INVITATIONS_READ,
                self::PROJECT_INVITATIONS_CREATE,
                self::PROJECT_INVITATIONS_UPDATE,
                self::PROJECT_INVITATIONS_DELETE,
            ],
            default => [],
        };
    }
}

