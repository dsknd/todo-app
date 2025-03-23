<?php

namespace App\UseCases;

use App\Exceptions\UnauthorizedProjectAccessException;
use App\ValueObjects\UserId;
use App\ValueObjects\ProjectId;
use App\ValueObjects\PermissionId;

interface AuthorizeProjectPermissionUseCase
{
    /**
     * ユーザーが指定されたプロジェクトに対して特定の権限を持っているかチェックします
     *
     * @param UserId $userId ユーザーID
     * @param ProjectId $projectId プロジェクトID
     * @param PermissionId $permissionId 必要な権限ID
     * @throws UnauthorizedProjectAccessException 権限がない場合
     * @return bool
     */
    public function execute(UserId $userId, ProjectId $projectId, PermissionId $permissionId): bool;
} 