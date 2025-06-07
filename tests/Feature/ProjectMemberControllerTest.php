<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Project;
use App\Models\ProjectMember;
use App\Models\ProjectRole;
use App\Enums\DefaultProjectRoleEnum;
use Laravel\Sanctum\Sanctum;
use Database\Seeders\LocaleSeeder;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\ProjectPermissionSeeder;
use Database\Seeders\DefaultProjectRoleSeeder;
use Database\Seeders\ProjectRoleTypeSeeder;

class ProjectMemberControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // 必要なシーダーを実行（依存関係の順序に注意）
        $this->seed([
            LocaleSeeder::class,
            PermissionSeeder::class,
            ProjectPermissionSeeder::class,
            ProjectRoleTypeSeeder::class,  // DefaultProjectRoleSeederより先に実行
            DefaultProjectRoleSeeder::class,
        ]);
    }


}