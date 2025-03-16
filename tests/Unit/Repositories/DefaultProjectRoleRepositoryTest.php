<?php

namespace Tests\Unit\Repositories;

use App\Models\DefaultProjectRole;
use App\Models\Project;
use App\Models\ProjectRole;
use App\Models\ProjectRoleType;
use App\Repositories\Interfaces\DefaultProjectRoleRepository;
use App\ValueObjects\ProjectRoleId;
use App\Enums\ProjectRoleTypeEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Group;
use Tests\TestCase;

#[Group('repository')]
#[Group('default_project_role')]
class DefaultProjectRoleRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected DefaultProjectRoleRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = app(DefaultProjectRoleRepository::class);
    }

    public function test_it_can_find_default_project_role_by_project_role_id()
    {
        // 準備
        $projectRoleType = ProjectRoleType::factory()->create([
            'key' => ProjectRoleTypeEnum::DEFAULT->getKey(),
        ]);
        
        $projectRole = ProjectRole::factory()->create([
            'project_role_type_id' => $projectRoleType->id,
        ]);
        
        $defaultProjectRole = new DefaultProjectRole();
        $defaultProjectRole->project_role_id = $projectRole->id;
        $defaultProjectRole->save();

        // 実行
        $foundDefaultProjectRole = $this->repository->findByProjectRoleId($projectRole->id);

        // 検証
        $this->assertNotNull($foundDefaultProjectRole);
        $this->assertTrue($projectRole->id->equals($foundDefaultProjectRole->project_role_id));
    }

    public function test_it_returns_null_when_default_project_role_not_found()
    {
        // 実行
        $foundDefaultProjectRole = $this->repository->findByProjectRoleId(new ProjectRoleId(999));

        // 検証
        $this->assertNull($foundDefaultProjectRole);
    }
} 