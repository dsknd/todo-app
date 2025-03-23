<?php

namespace App\Interactors;

use App\UseCases\AuthorizeProjectPermissionUseCase;
use App\ValueObjects\UserId;
use App\ValueObjects\ProjectId;
use App\ValueObjects\PermissionId;
use App\Repositories\Interfaces\ProjectRepository;
use App\Repositories\Interfaces\ProjectMemberRepository;
use App\Repositories\Interfaces\PermissionRepository;
class AuthorizeProjectPermissionInteractor implements AuthorizeProjectPermissionUseCase
{
    /**
     * @param ProjectRepository $projectRepository
     * @param ProjectMemberRepository $projectMemberRepository
     * @param PermissionRepository $permissionRepository
     */
    public function __construct(
        private readonly ProjectRepository $projectRepository,
        private readonly ProjectMemberRepository $projectMemberRepository,
        private readonly PermissionRepository $permissionRepository,
    ) {}

    /**
     * @inheritDoc
     */
    public function execute(UserId $userId, ProjectId $projectId, PermissionId $permissionId): bool
    {
        // ロールを取得
        $member = $this->projectMemberRepository->findByProjectIdAndUserId($projectId, $userId);

        // ロールが持つ権限を取得
        $permissionIds = $member->role->projectPermissions->pluck('permission_id')->toArray();

        // ロールが持つ権限が、指定された権限を含むかどうかを確認
        return $this->permissionRepository->areIncludedIn($permissionIds, $permissionId);
    }
} 