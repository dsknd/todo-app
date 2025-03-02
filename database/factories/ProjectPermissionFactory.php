<?php

namespace Database\Factories;

use App\Models\ProjectPermission;
use App\Enums\ProjectPermissionEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectPermissionFactory extends Factory
{
    protected $model = ProjectPermission::class;

    public function definition(): array
    {
        // 単一のレコードを返すように修正
        $now = now();
        return [
            'permission_id' => $this->faker->numberBetween(1, 24),
            'created_at' => $now,
            'updated_at' => $now,
        ];
    }
    
    /**
     * すべてのプロジェクト権限を作成するメソッド
     */
    public function createAll()
    {
        $now = now();
        $projectPermissions = [];
        
        foreach (ProjectPermissionEnum::cases() as $projectPermission) {
            $projectPermissions[] = ProjectPermission::create([
                'permission_id' => $projectPermission->value,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
        
        return $projectPermissions;
    }
} 