<?php

namespace App\Interactors;

use App\UseCases\AuthorizeProjectPermissionUseCase;
use App\ValueObjects\UserId;
use App\ValueObjects\ProjectId;
use App\ValueObjects\PermissionId;
use App\Repositories\Interfaces\ProjectMemberQueryRepository;
use App\Repositories\Interfaces\PermissionRepository;
class AuthorizeProjectPermissionInteractor implements AuthorizeProjectPermissionUseCase
{
    /**
     * @param ProjectMemberQueryRepository $projectMemberQueryRepository
     * @param PermissionRepository $permissionRepository
     */
    public function __construct(
        private readonly ProjectMemberQueryRepository $projectMemberQueryRepository,
        private readonly PermissionRepository $permissionRepository,
    ) {}

    /**
     * @inheritDoc
     */
    public function execute(UserId $userId, ProjectId $projectId, PermissionId $permissionId): bool
    {
        // ロールを取得
        $permissions = $this->projectMemberQueryRepository->findMemberPermissions($projectId, $userId);

        // ロールが持つ権限を取得
        $permissionIds = $permissions->permissions->pluck('permission_id')->toArray();

        // ロールが持つ権限が、指定された権限を含むかどうかを確認
        return $this->permissionRepository->areIncludedIn($permissionIds, $permissionId);
    }
} 