<?php

namespace App\Policies;

use App\Models\ProjectRole;
use App\Models\User;
use App\Models\Project;
use Illuminate\Auth\Access\Response;
use App\Enums\ProjectPermissions;
use Illuminate\Support\Facades\Log;
use App\Models\Permission;
use App\UseCases\CheckProjectRolePermissionUseCase;

/**
 * プロジェクトロールのポリシー
 */
class ProjectRolePolicy
{
    private CheckProjectRolePermissionUseCase $checkProjectRolePermissionUseCase;

    public function __construct(CheckProjectRolePermissionUseCase $checkProjectRolePermissionUseCase)
    {
        $this->checkProjectRolePermissionUseCase = $checkProjectRolePermissionUseCase;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * プロジェクトロールを閲覧できるかどうかを判定する
     */
    public function view(User $user, int $projectId): bool
    {
        // プロジェクトロールを閲覧するために必要な権限
        $requiredPermission = ProjectPermissions::PROJECT_ROLE_READ();

        // ユーザーがプロジェクトロールを閲覧するために必要な権限を持っているかどうかを判定する
        $hasRequiredPermission = $this->checkProjectRolePermissionUseCase->hasPermission(
            $user,
            $projectId,
            $requiredPermission
        );

        return $hasRequiredPermission;
    }

    /**
     * プロジェクトロールを作成できるかどうかを判定する
     */
    public function create(User $user, int $projectId): bool
    {
        // プロジェクトロールを作成するために必要な権限
        $requiredPermission = ProjectPermissions::PROJECT_ROLE_CREATE();

        // ユーザーがプロジェクトロールを作成するために必要な権限を持っているかどうかを判定する
        $hasRequiredPermission = $this->checkProjectRolePermissionUseCase->hasPermission(
            $user,
            $projectId,
            $requiredPermission
        );

        // 必要な権限を持っている場合は true を返す
        return $hasRequiredPermission;
    }
    
    /**
     * プロジェクトロールを更新できるかどうかを判定する
     */
    public function update(User $user, int $projectId): bool
    {
        // プロジェクトロールを更新するために必要な権限
        $requiredPermission = ProjectPermissions::PROJECT_ROLE_UPDATE();

        // ユーザーがプロジェクトロールを更新するために必要な権限を持っているかどうかを判定する
        $hasRequiredPermission = $this->checkProjectRolePermissionUseCase->hasPermission(
            $user,
            $projectId,
            $requiredPermission
        );

        // 必要な権限を持っている場合は true を返す
        return $hasRequiredPermission;
    }

    /**
     * プロジェクトロールを削除できるかどうかを判定する
     */
    public function delete(User $user, int $projectId): bool
    {
        // プロジェクトロールを削除するために必要な権限
        $requiredPermission = ProjectPermissions::PROJECT_ROLE_DELETE();

        // ユーザーがプロジェクトロールを削除するために必要な権限を持っているかどうかを判定する
        $hasRequiredPermission = $this->checkProjectRolePermissionUseCase->hasPermission(
            $user,
            $projectId,
            $requiredPermission
        );

        // 必要な権限を持っている場合は true を返す
        return $hasRequiredPermission;
    }

    /**
     * プロジェクトロールを復元できるかどうかを判定する
     */
    public function restore(User $user, ProjectRole $projectRole): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ProjectRole $projectRole): bool
    {
        return false;
    }
}
