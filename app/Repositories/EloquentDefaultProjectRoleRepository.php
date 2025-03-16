<?php

namespace App\Repositories;

use App\Models\DefaultProjectRole;
use App\Models\ProjectRole;
use App\Models\ProjectRoleType;
use App\Repositories\Interfaces\DefaultProjectRoleRepository;
use App\ValueObjects\ProjectRoleId;
use App\Enums\ProjectRoleTypeEnum;
use Illuminate\Support\Collection;

class EloquentDefaultProjectRoleRepository implements DefaultProjectRoleRepository
{
    /**
     * プロジェクトロールIDでデフォルトプロジェクトロールを検索
     *
     * @param ProjectRoleId $projectRoleId
     * @return DefaultProjectRole|null
     */
    public function findByProjectRoleId(ProjectRoleId $projectRoleId): ?DefaultProjectRole
    {
        return DefaultProjectRole::where('project_role_id', $projectRoleId->getValue())->first();
    }

    /**
     * 名前でデフォルトプロジェクトロールを検索
     *
     * @param string $name
     * @return DefaultProjectRole|null
     */
    public function findByName(string $name): ?DefaultProjectRole
    {
        // DefaultProjectRoleとProjectRoleを結合して検索
        $projectRole = ProjectRole::join('default_project_roles', 'project_roles.id', '=', 'default_project_roles.project_role_id')
            ->where('project_roles.name', $name)
            ->select('default_project_roles.*')
            ->first();

        return $projectRole ? DefaultProjectRole::find($projectRole->project_role_id) : null;
    }

    /**
     * すべてのデフォルトプロジェクトロールを取得
     *
     * @return Collection
     */
    public function findAll(): Collection
    {
        return DefaultProjectRole::all();
    }

    /**
     * デフォルトプロジェクトロールを作成
     *
     * @param array $attributes
     * @return DefaultProjectRole
     */
    public function create(array $attributes): DefaultProjectRole
    {
        // まずProjectRoleを作成
        $projectRoleAttributes = [
            'project_id' => $attributes['project_id'] ?? null,
            'name' => $attributes['name'],
            'description' => $attributes['description'] ?? null,
            'project_role_type_id' => ProjectRoleType::where('key', ProjectRoleTypeEnum::DEFAULT->getKey())->first()->id->getValue(),
        ];

        $projectRole = ProjectRole::create($projectRoleAttributes);

        // 次にDefaultProjectRoleを作成
        $defaultProjectRole = new DefaultProjectRole();
        $defaultProjectRole->project_role_id = $projectRole->id;
        $defaultProjectRole->save();

        return $defaultProjectRole;
    }

    /**
     * デフォルトプロジェクトロールを更新
     *
     * @param ProjectRoleId $projectRoleId
     * @param array $attributes
     * @return bool
     */
    public function update(ProjectRoleId $projectRoleId, array $attributes): bool
    {
        $defaultProjectRole = $this->findByProjectRoleId($projectRoleId);

        if (!$defaultProjectRole) {
            return false;
        }

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
     * デフォルトプロジェクトロールを削除
     *
     * @param ProjectRoleId $projectRoleId
     * @return bool
     */
    public function delete(ProjectRoleId $projectRoleId): bool
    {
        $defaultProjectRole = $this->findByProjectRoleId($projectRoleId);

        if (!$defaultProjectRole) {
            return false;
        }

        // DefaultProjectRoleを削除
        $result = $defaultProjectRole->delete();

        // ProjectRoleも削除
        $projectRole = ProjectRole::find($projectRoleId->getValue());
        if ($projectRole) {
            $projectRole->delete();
        }

        return $result;
    }

    /**
     * デフォルトプロジェクトロールが存在するかどうかを確認
     *
     * @param ProjectRoleId $projectRoleId
     * @return bool
     */
    public function exists(ProjectRoleId $projectRoleId): bool
    {
        return DefaultProjectRole::where('project_role_id', $projectRoleId->getValue())->exists();
    }

    /**
     * プロジェクトロールがデフォルトロールかどうかを確認
     *
     * @param ProjectRoleId $projectRoleId
     * @return bool
     */
    public function isDefaultRole(ProjectRoleId $projectRoleId): bool
    {
        return $this->exists($projectRoleId);
    }
} 