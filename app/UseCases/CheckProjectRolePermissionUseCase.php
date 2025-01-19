<?php

namespace App\UseCases;

use App\Enums\ProjectPermissions;
use App\Models\User;
use App\Models\Project;

interface CheckProjectRolePermissionUseCase
{
    /**
     * ユーザーがプロジェクトの特定の権限を持っているかどうかをチェックする
     *
     * @param User $user 権限をチェックするユーザー
     * @param Project $project 権限をチェックするプロジェクト
     * @param ProjectPermissions $requiredPermission 必要な権限
     * @return bool ユーザーが必要な権限を持っている場合は true, そうでない場合は false
     */
    public function hasPermission(User $user, Project $project, ProjectPermissions $requiredPermission): bool;
}

