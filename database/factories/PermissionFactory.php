<?php

namespace Database\Factories;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\PermissionEnum;

class PermissionFactory extends Factory
{
    protected $model = Permission::class;

    public function definition(): array
    {
        // 単一のレコードを返すように修正
        return [
            'scope' => $this->faker->word(),
            'resource' => $this->faker->word(),
            'action' => $this->faker->word(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
    
    /**
     * すべての権限を作成するメソッド
     */
    public function createAll()
    {
        $permissions = [];
        
        foreach (PermissionEnum::cases() as $permission) {
            $permissions[] = Permission::create([
                'id' => $permission->value,
                'scope' => PermissionEnum::getScope($permission),
                'resource' => PermissionEnum::getResource($permission),
                'action' => PermissionEnum::getAction($permission),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        return $permissions;
    }
} 