<?php

namespace Database\Factories;

use App\Models\Permission;
use App\Models\ProjectPermission;
use App\ValueObjects\PermissionId;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectPermissionFactory extends Factory
{
    /**
     * モデルと対応するファクトリーの定義
     *
     * @var string
     */
    protected $model = ProjectPermission::class;

    /**
     * ファクトリーのデフォルト状態を定義
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'permission_id' => Permission::factory(),
        ];
    }

    /**
     * 権限IDを指定して作成
     *
     * @param PermissionId $permissionId
     * @return self
     */
    public function withPermissionId(PermissionId $permissionId): self
    {
        return $this->state(function (array $attributes) use ($permissionId) {
            return [
                'permission_id' => $permissionId->getValue(),
            ];
        });
    }
} 