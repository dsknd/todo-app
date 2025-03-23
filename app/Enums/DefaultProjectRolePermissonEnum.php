<?php

namespace App\Enums;

enum DefaultProjectRolePermissonEnum: int
{
    case OWNER = 1;
    case ADMIN = 2;
    case MEMBER = 3;
    case VIEWER = 4;
    case GUEST = 5;

    /**
     * オーナーの権限
     * @return array<ProjectPermissionEnum>
     */
    public static function getOwnerPermissions(): array
    {
        return [
            ProjectPermissionEnum::PROJECT_WILDCARD,
            ProjectPermissionEnum::PROJECT_READ,
            ProjectPermissionEnum::PROJECT_UPDATE,
            ProjectPermissionEnum::PROJECT_DELETE,
            ProjectPermissionEnum::PROJECT_TASK_WILDCARD,
            ProjectPermissionEnum::PROJECT_TASK_READ,
            ProjectPermissionEnum::PROJECT_TASK_CREATE,
            ProjectPermissionEnum::PROJECT_TASK_UPDATE,
            ProjectPermissionEnum::PROJECT_TASK_DELETE,
            ProjectPermissionEnum::PROJECT_ROLE_WILDCARD,
            ProjectPermissionEnum::PROJECT_ROLE_READ,
            ProjectPermissionEnum::PROJECT_ROLE_CREATE,
            ProjectPermissionEnum::PROJECT_ROLE_UPDATE,
            ProjectPermissionEnum::PROJECT_ROLE_DELETE,
            ProjectPermissionEnum::PROJECT_MEMBER_WILDCARD,
            ProjectPermissionEnum::PROJECT_MEMBER_READ,
            ProjectPermissionEnum::PROJECT_MEMBER_CREATE,
            ProjectPermissionEnum::PROJECT_MEMBER_UPDATE,
            ProjectPermissionEnum::PROJECT_MEMBER_DELETE,
            ProjectPermissionEnum::PROJECT_INVITATION_WILDCARD,
            ProjectPermissionEnum::PROJECT_INVITATION_READ,
            ProjectPermissionEnum::PROJECT_INVITATION_CREATE,
            ProjectPermissionEnum::PROJECT_INVITATION_UPDATE,
            ProjectPermissionEnum::PROJECT_INVITATION_DELETE,
        ];
    }

    /**
     * 管理者の権限
     * @return array<PermissionEnum>
     */
    public static function getAdminPermissions(): array
    {
        return [
            ProjectPermissionEnum::PROJECT_READ,
            ProjectPermissionEnum::PROJECT_UPDATE,
            ProjectPermissionEnum::PROJECT_TASK_WILDCARD,
            ProjectPermissionEnum::PROJECT_TASK_READ,
            ProjectPermissionEnum::PROJECT_TASK_CREATE,
            ProjectPermissionEnum::PROJECT_TASK_UPDATE,
            ProjectPermissionEnum::PROJECT_TASK_DELETE,
            ProjectPermissionEnum::PROJECT_ROLE_WILDCARD,
            ProjectPermissionEnum::PROJECT_ROLE_READ,
            ProjectPermissionEnum::PROJECT_ROLE_CREATE,
            ProjectPermissionEnum::PROJECT_ROLE_UPDATE,
            ProjectPermissionEnum::PROJECT_ROLE_DELETE,
            ProjectPermissionEnum::PROJECT_MEMBER_WILDCARD,
            ProjectPermissionEnum::PROJECT_MEMBER_READ,
            ProjectPermissionEnum::PROJECT_MEMBER_CREATE,
            ProjectPermissionEnum::PROJECT_MEMBER_UPDATE,
            ProjectPermissionEnum::PROJECT_MEMBER_DELETE,
            ProjectPermissionEnum::PROJECT_INVITATION_WILDCARD,
            ProjectPermissionEnum::PROJECT_INVITATION_READ,
            ProjectPermissionEnum::PROJECT_INVITATION_CREATE,
            ProjectPermissionEnum::PROJECT_INVITATION_UPDATE,
            ProjectPermissionEnum::PROJECT_INVITATION_DELETE,
        ];
    }

    /**
     * メンバーの権限
     * @return array<PermissionEnum>
     */
    public static function getMemberPermissions(): array
    {
        return [
            ProjectPermissionEnum::PROJECT_READ,
            ProjectPermissionEnum::PROJECT_TASK_WILDCARD,
            ProjectPermissionEnum::PROJECT_TASK_READ,
            ProjectPermissionEnum::PROJECT_TASK_CREATE,
            ProjectPermissionEnum::PROJECT_TASK_UPDATE,
            ProjectPermissionEnum::PROJECT_TASK_DELETE,
            ProjectPermissionEnum::PROJECT_ROLE_READ,
            ProjectPermissionEnum::PROJECT_MEMBER_READ,
            ProjectPermissionEnum::PROJECT_INVITATION_READ,
        ];
    }

    /**
     * 閲覧者の権限
     * @return array<PermissionEnum>
     */
    public static function getViewerPermissions(): array
    {
        return [
            ProjectPermissionEnum::PROJECT_READ,
            ProjectPermissionEnum::PROJECT_TASK_READ,
            ProjectPermissionEnum::PROJECT_ROLE_READ,
            ProjectPermissionEnum::PROJECT_MEMBER_READ,
        ];
    }

    /**
     * ゲストの権限
     * @return array<PermissionEnum>
     */
    public static function getGuestPermissions(): array
    {
        return [
            ProjectPermissionEnum::PROJECT_READ,
            ProjectPermissionEnum::PROJECT_TASK_READ,
        ];
    }

    /**
     * デフォルトロールの権限を取得
     * @param DefaultProjectRoleEnum $role
     * @return array<PermissionEnum>
     */
    public static function getPermissions(DefaultProjectRoleEnum $role): array
    {
        return match($role) {
            DefaultProjectRoleEnum::OWNER => self::getOwnerPermissions(),
            DefaultProjectRoleEnum::ADMIN => self::getAdminPermissions(),
            DefaultProjectRoleEnum::MEMBER => self::getMemberPermissions(),
            DefaultProjectRoleEnum::VIEWER => self::getViewerPermissions(),
            DefaultProjectRoleEnum::GUEST => self::getGuestPermissions(),
        };
    }
}