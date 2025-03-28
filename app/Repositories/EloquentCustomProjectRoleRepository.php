<?php

namespace App\Repositories;

use App\Models\CustomProjectRole;
use App\Models\ProjectRole;
use App\Repositories\Interfaces\CustomProjectRoleRepository;
use App\ValueObjects\ProjectId;
use App\ValueObjects\ProjectRoleId;
use App\ValueObjects\ProjectRoleNumber;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class EloquentCustomProjectRoleRepository implements CustomProjectRoleRepository
{
    /**
     * プロジェクトロールIDでカスタムプロジェクトロールを検索
     *
     * @param ProjectRoleId $projectRoleId
     * @return CustomProjectRole|null
     */
    public function findByProjectRoleId(ProjectRoleId $projectRoleId): ?CustomProjectRole
    {
        return CustomProjectRole::where('project_role_id', $projectRoleId)->first();
    }

    /**
     * プロジェクトIDとロール番号でカスタムプロジェクトロールを検索
     *
     * @param ProjectId $projectId
     * @param ProjectRoleNumber $roleNumber
     * @return CustomProjectRole|null
     */
    public function findByProjectIdAndRoleNumber(ProjectId $projectId, ProjectRoleNumber $roleNumber): ?CustomProjectRole
    {
        return CustomProjectRole::where('project_id', $projectId)
            ->where('role_number', $roleNumber)
            ->first();
    }

    /**
     * プロジェクトIDに関連するすべてのカスタムロールを取得
     *
     * @param ProjectId $projectId
     * @return Collection
     */
    public function findAllByProjectId(ProjectId $projectId): Collection
    {
        return CustomProjectRole::where('project_id', $projectId)
            ->orderBy('role_number')
            ->get();
    }

    /**
     * プロジェクトIDに関連するカスタムロールをページネーションで取得
     *
     * @param ProjectId $projectId
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function findByProjectIdPaginated(ProjectId $projectId, int $perPage = 15): LengthAwarePaginator
    {
        return CustomProjectRole::where('project_id', $projectId)
            ->orderBy('role_number')
            ->paginate($perPage);
    }

    /**
     * カスタムプロジェクトロールを作成
     *
     * @param ProjectRoleId $projectRoleId
     * @param array $attributes
     * @return CustomProjectRole
     */
    public function create(ProjectRoleId $projectRoleId, array $attributes): CustomProjectRole
    {
        // 次にCustomProjectRoleを作成
        $customProjectRole = new CustomProjectRole();
        $customProjectRole->project_role_id = $projectRoleId;
        $customProjectRole->project_id = $attributes['project_id'];
        $customProjectRole->name = $attributes['name'];
        $customProjectRole->description = $attributes['description'] ?? null;
        $customProjectRole->save();

        return $customProjectRole;
    }

    /**
     * カスタムプロジェクトロールを更新
     *
     * @param ProjectRoleId $projectRoleId
     * @param array $attributes
     * @return bool
     */
    public function update(ProjectRoleId $projectRoleId, array $attributes): bool
    {
        $customProjectRole = $this->findByProjectRoleId($projectRoleId);

        if (!$customProjectRole) {
            return false;
        }

        // CustomProjectRoleを更新
        $customProjectRole->name = $attributes['name'] ?? $customProjectRole->name;
        $customProjectRole->description = $attributes['description'] ?? $customProjectRole->description;
        $customProjectRole->save();

        // ProjectRoleも更新
        $projectRole = ProjectRole::find($projectRoleId->getValue());
        if ($projectRole) {
            $projectRole->update([
                'name' => $attributes['name'] ?? $projectRole->name,
                'description' => $attributes['description'] ?? $projectRole->description,
            ]);
        }

        return true;
    }

    /**
     * カスタムプロジェクトロールを削除
     *
     * @param ProjectRoleId $projectRoleId
     * @return bool
     */
    public function delete(ProjectRoleId $projectRoleId): bool
    {
        $customProjectRole = $this->findByProjectRoleId($projectRoleId);

        if (!$customProjectRole) {
            return false;
        }

        return $customProjectRole->delete();
    }

    /**
     * カスタムプロジェクトロールが存在するかどうかを確認
     *
     * @param ProjectRoleId $projectRoleId
     * @return bool
     */
    public function exists(ProjectRoleId $projectRoleId): bool
    {
        return CustomProjectRole::where('project_role_id', $projectRoleId)->exists();
    }

    /**
     * プロジェクトロールがカスタムロールかどうかを確認
     *
     * @param ProjectRoleId $projectRoleId
     * @return bool
     */
    public function isCustomRole(ProjectRoleId $projectRoleId): bool
    {
        return $this->exists($projectRoleId);
    }
} 