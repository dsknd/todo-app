<?php

namespace Database\Factories;

use App\Models\Permission;
use App\Models\PermissionClosure;
use Illuminate\Database\Eloquent\Factories\Factory;
class PermissionClosureFactory extends Factory
{
    /**
     * モデルと対応するファクトリーの定義
     *
     * @var string
     */
    protected $model = PermissionClosure::class;

    /**
     * ファクトリーのデフォルト状態を定義
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ancestor_id' => Permission::factory(),
            'descendant_id' => Permission::factory(),
            'depth' => $this->faker->numberBetween(0, 5),
        ];
    }

    /**
     * 特定の祖先権限IDを使用
     *
     * @param int|Permission|\App\ValueObjects\PermissionId $ancestorId
     * @return self
     */
    public function withAncestor($ancestorId): self
    {
        $id = $this->resolveId($ancestorId);
        
        return $this->state(function (array $attributes) use ($id) {
            return [
                'ancestor_id' => $id,
            ];
        });
    }

    /**
     * 特定の子孫権限IDを使用
     *
     * @param int|Permission|\App\ValueObjects\PermissionId $descendantId
     * @return self
     */
    public function withDescendant($descendantId): self
    {
        $id = $this->resolveId($descendantId);
        
        return $this->state(function (array $attributes) use ($id) {
            return [
                'descendant_id' => $id,
            ];
        });
    }

    /**
     * 特定の深さを使用
     *
     * @param int $depth
     * @return self
     */
    public function withDepth(int $depth): self
    {
        return $this->state(function (array $attributes) use ($depth) {
            return [
                'depth' => $depth,
            ];
        });
    }

    /**
     * 自己参照（深さ0）のクロージャーを作成
     *
     * @param int|Permission|\App\ValueObjects\PermissionId $permissionId
     * @return self
     */
    public function selfReference($permissionId): self
    {
        $id = $this->resolveId($permissionId);
        
        return $this->state(function (array $attributes) use ($id) {
            return [
                'ancestor_id' => $id,
                'descendant_id' => $id,
                'depth' => 0,
            ];
        });
    }

    /**
     * 親子関係（深さ1）のクロージャーを作成
     *
     * @param int|Permission|\App\ValueObjects\PermissionId $parentId
     * @param int|Permission|\App\ValueObjects\PermissionId $childId
     * @return self
     */
    public function parentChild($parentId, $childId): self
    {
        $parentIdValue = $this->resolveId($parentId);
        $childIdValue = $this->resolveId($childId);
        
        return $this->state(function (array $attributes) use ($parentIdValue, $childIdValue) {
            return [
                'ancestor_id' => $parentIdValue,
                'descendant_id' => $childIdValue,
                'depth' => 1,
            ];
        });
    }

    /**
     * IDを解決する内部ヘルパーメソッド
     *
     * @param int|Permission|\App\ValueObjects\PermissionId $id
     * @return int
     */
    private function resolveId($id): int
    {
        if ($id instanceof Permission) {
            return $id->id->getValue();
        }
        
        if (is_object($id) && method_exists($id, 'getValue')) {
            return $id->getValue();
        }
        
        return (int) $id;
    }
} 