<?php declare(strict_types=1);

namespace App\Enums;
use App\Enums\PermissionEnum;
/**
 * プロジェクトの権限IDを定義するEnumクラス
 * 
 * このEnumクラスは、プロジェクトの権限を定義するために使用されます。
 * 以下で定義されている権限を使用しています。
 * 
 * @method static static PROJECT_WILDCARD()
 * @method static static PROJECT_READ()
 * @method static static PROJECT_UPDATE()
 * @method static static PROJECT_DELETE()
 * 
 * @method static static PROJECT_TASK_WILDCARD()
 * @method static static PROJECT_TASK_READ()
 * @method static static PROJECT_TASK_CREATE()
 * @method static static PROJECT_TASK_UPDATE()
 * @method static static PROJECT_TASK_DELETE()
 * 
 * @method static static PROJECT_ROLE_WILDCARD()
 * @method static static PROJECT_ROLE_READ()
 * @method static static PROJECT_ROLE_CREATE()
 * @method static static PROJECT_ROLE_UPDATE()
 * @method static static PROJECT_ROLE_DELETE()
 * 
 * @method static static PROJECT_MEMBER_WILDCARD()
 * @method static static PROJECT_MEMBER_READ()
 * @method static static PROJECT_MEMBER_CREATE()
 * @method static static PROJECT_MEMBER_UPDATE()
 * @method static static PROJECT_MEMBER_DELETE()
 * 
 * @method static static PROJECT_INVITATION_WILDCARD()
 * @method static static PROJECT_INVITATION_READ()
 * @method static static PROJECT_INVITATION_CREATE()
 * @method static static PROJECT_INVITATION_UPDATE()
 * @method static static PROJECT_INVITATION_DELETE()
 */
enum ProjectPermissionEnum: int
{
    const PROJECT_WILDCARD = 1;
    const PROJECT_READ = 2;
    const PROJECT_UPDATE = 3;
    const PROJECT_DELETE = 4;

    const PROJECT_TASK_WILDCARD = 5;
    const PROJECT_TASK_READ = 6;
    const PROJECT_TASK_CREATE = 7;
    const PROJECT_TASK_UPDATE = 8;
    const PROJECT_TASK_DELETE = 9;

    const PROJECT_ROLE_WILDCARD = 10;
    const PROJECT_ROLE_READ = 11;
    const PROJECT_ROLE_CREATE = 12;
    const PROJECT_ROLE_UPDATE = 13;
    const PROJECT_ROLE_DELETE = 14;

    const PROJECT_MEMBER_WILDCARD = 15;
    const PROJECT_MEMBER_READ = 16;
    const PROJECT_MEMBER_CREATE = 17;
    const PROJECT_MEMBER_UPDATE = 18;
    const PROJECT_MEMBER_DELETE = 19;

    const PROJECT_INVITATION_WILDCARD = 20;
    const PROJECT_INVITATION_READ = 21;
    const PROJECT_INVITATION_CREATE = 22;
    const PROJECT_INVITATION_UPDATE = 23;
    const PROJECT_INVITATION_DELETE = 24;

    public static function getScope(mixed $value): string
    {
        return PermissionEnum::getScope($value);
    }

    public static function getResource(mixed $value): string
    {
        return PermissionEnum::getResource($value);
    }

    public static function getAction(mixed $value): string
    {
        return PermissionEnum::getAction($value);
    }

    public static function getDisplayName(mixed $value): string
    {
        return PermissionEnum::getDisplayName($value);
    }

    public static function getDescription(mixed $value): string
    {
        return PermissionEnum::getDescription($value);
    }

    public static function getHierarchy(mixed $value): array
    {
        return PermissionEnum::getHierarchy($value);
    }
}
