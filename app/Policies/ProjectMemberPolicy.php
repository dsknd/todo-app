<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Project;
use App\Models\ProjectMember;
use App\Enums\PermissionEnum;
use App\ValueObjects\PermissionId;
use App\UseCases\AuthorizeProjectPermissionUseCase;

class ProjectMemberPolicy
{
    public function __construct(
        private readonly AuthorizeProjectPermissionUseCase $authorizePermission
    ) {
    }

    /**
     * プロジェクトメンバー一覧の閲覧権限
     */
    public function viewAny(User $user, Project $project): bool
    {
        // プロジェクトメンバーの閲覧権限をチェック
        return $this->authorizePermission->execute(
            $user->id,
            $project->id,
            PermissionId::fromEnum(PermissionEnum::PROJECT_MEMBERS_READ)
        );
    }

    /**
     * 特定のプロジェクトメンバーの閲覧権限
     */
    public function view(User $user, Project $project, ProjectMember $member): bool
    {
        // プロジェクトが一致していることを確認
        if (!$member->project_id->equals($project->id)) {
            return false;
        }

        // プロジェクトメンバーの閲覧権限をチェック
        return $this->authorizePermission->execute(
            $user->id,
            $project->id,
            PermissionId::fromEnum(PermissionEnum::PROJECT_MEMBERS_READ)
        );
    }

    /**
     * プロジェクトメンバーの追加権限
     */
    public function create(User $user, Project $project): bool
    {
        // プロジェクトメンバーの管理権限をチェック
        return $this->authorizePermission->execute(
            $user->id,
            $project->id,
            PermissionId::fromEnum(PermissionEnum::PROJECT_MEMBERS_CREATE)
        );
    }

    /**
     * プロジェクトメンバーの更新権限（ロール変更など）
     */
    public function update(User $user, Project $project, ProjectMember $member): bool
    {
        // プロジェクトが一致していることを確認
        if (!$member->project_id->equals($project->id)) {
            return false;
        }

        // 自分自身のロールを変更しようとしている場合は拒否
        if ($member->user_id->equals($user->id)) {
            return false;
        }

        // プロジェクトメンバーの管理権限をチェック
        return $this->authorizePermission->execute(
            $user->id,
            $project->id,
            PermissionId::fromEnum(PermissionEnum::PROJECT_MEMBERS_UPDATE)
        );
    }

    /**
     * プロジェクトメンバーの削除権限
     */
    public function delete(User $user, Project $project, ProjectMember $member): bool
    {
        // プロジェクトが一致していることを確認
        if (!$member->project_id->equals($project->id)) {
            return false;
        }

        // 自分自身を削除する場合（プロジェクトからの離脱）
        if ($member->user_id->equals($user->id)) {
            // プロジェクトオーナーは離脱できない
            if ($project->created_by->equals($user->id)) {
                return false;
            }
            // 一般メンバーは自由に離脱可能
            return true;
        }

        // 他のメンバーを削除する場合は管理権限が必要
        return $this->authorizePermission->execute(
            $user->id,
            $project->id,
            PermissionId::fromEnum(PermissionEnum::PROJECT_MEMBERS_DELETE)
        );
    }

    /**
     * プロジェクトへの招待権限
     */
    public function invite(User $user, Project $project): bool
    {
        // プロジェクトメンバーの管理権限をチェック
        return $this->authorizePermission->execute(
            $user->id,
            $project->id,
            PermissionId::fromEnum(PermissionEnum::PROJECT_MEMBERS_CREATE)
        );
    }
}