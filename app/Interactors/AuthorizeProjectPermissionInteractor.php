<?php

namespace App\Interactors;

use App\UseCases\AuthorizeProjectPermissionUseCase;
use App\ValueObjects\UserId;
use App\ValueObjects\ProjectId;
use App\ValueObjects\PermissionId;
use App\Repositories\Interfaces\ProjectMemberPermissionQueryRepository;
use App\Repositories\Interfaces\PermissionRepository;

/**
 * プロジェクトの権限を確認するインタラクタ
 */
class AuthorizeProjectPermissionInteractor implements AuthorizeProjectPermissionUseCase
{
    /**
     * @param ProjectMemberQueryRepository $projectMemberQueryRepository
     * @param PermissionRepository $permissionRepository
     */
    public function __construct(
        private readonly ProjectMemberPermissionQueryRepository $projectMemberPermissionQueryRepository,
        private readonly PermissionRepository $permissionRepository,
    ) {}

    /**
     * @inheritDoc
     */
    public function execute(UserId $userId, ProjectId $projectId, PermissionId $permissionId): bool
    {
        // ロールを取得
        $permissions = $this->projectMemberPermissionQueryRepository->findMemberPermissions($projectId, $userId);

        // ロールが持つ権限が、指定された権限を含むかどうかを確認
        return $this->permissionRepository->imply($permissions->getPermissionIds(), $permissionId);
    }
} 