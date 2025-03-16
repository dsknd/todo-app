<?php

namespace Database\Factories;

use App\Models\ProjectPermission;
use App\Models\ProjectRole;
use App\Models\ProjectRolePermission;
use App\ValueObjects\PermissionId;
use App\ValueObjects\ProjectRoleId;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectRolePermissionFactory extends Factory
{
    /**
     * モデルと対応するファクトリーの定義
     *
     * @var string
     */
    protected $model = ProjectRolePermission::class;

    /**
     * ファクトリーのデフォルト状態を定義
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'project_permission_id' => ProjectPermission::factory(),
            'project_role_id' => ProjectRole::factory(),
            'assigned_at' => now(),
        ];
    }

    /**
     * プロジェクトロールIDを指定して作成
     *
     * @param ProjectRoleId $projectRoleId
     * @return self
     */
    public function withRoleId(ProjectRoleId $projectRoleId): self
    {
        return $this->state(function (array $attributes) use ($projectRoleId) {
            return [
                'project_role_id' => $projectRoleId->getValue(),
            ];
        });
    }

    /**
     * プロジェクト権限IDを指定して作成
     *
     * @param PermissionId $permissionId
     * @return self
     */
    public function withPermissionId(PermissionId $permissionId): self
    {
        return $this->state(function (array $attributes) use ($permissionId) {
            return [
                'project_permission_id' => $permissionId->getValue(),
            ];
        });
    }

    /**
     * 割り当て日時を指定して作成
     *
     * @param \DateTimeImmutable $assignedAt
     * @return self
     */
    public function assignedAt(\DateTimeImmutable $assignedAt): self
    {
        return $this->state(function (array $attributes) use ($assignedAt) {
            return [
                'assigned_at' => $assignedAt,
            ];
        });
    }
} 