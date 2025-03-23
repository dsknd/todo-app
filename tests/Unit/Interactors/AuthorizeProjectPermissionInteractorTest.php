<?php

namespace Tests\Unit\Interactors;

use Tests\TestCase;
use App\Interactors\AuthorizeProjectPermissionInteractor;
use App\ValueObjects\UserId;
use App\ValueObjects\ProjectId;
use App\ValueObjects\PermissionId;
use App\Repositories\Interfaces\ProjectRepository;
use App\Repositories\Interfaces\ProjectMemberRepository;
use App\Repositories\Interfaces\PermissionRepository;
use App\Models\ProjectMember;
use App\Models\ProjectRole;
use App\Models\ProjectPermission;
use Mockery;
use Illuminate\Support\Collection;
use App\Exceptions\UnauthorizedProjectAccessException;
use App\Models\Permission;
use Tests\Helpers\PermissionHierarchySetup;
use App\Models\User;
use App\Models\Project;
use App\Models\ProjectRolePermission;
use App\Models\CustomProjectRole;
use App\Models\PermissionClosure;
use Illuminate\Foundation\Testing\RefreshDatabase;
class AuthorizeProjectPermissionInteractorTest extends TestCase
{
    use RefreshDatabase;

    private AuthorizeProjectPermissionInteractor $interactor;

    protected function setUp(): void
    {
        parent::setUp();

        $this->interactor = app(AuthorizeProjectPermissionInteractor::class);
    }

    public function test_can_authorize_successfully(): void
    {
        // 準備
        $parentPermission = Permission::factory()->create();
        $childPermission = Permission::factory()->create();

        ProjectPermission::factory()->create(['permission_id' => $parentPermission->id]);
        ProjectPermission::factory()->create(['permission_id' => $childPermission->id]);

        PermissionHierarchySetup::setupParentChild(
            $parentPermission,
            $childPermission
        );
        
        $user = User::factory()->create();
        $customProjectRole = CustomProjectRole::factory()->create();

        ProjectRolePermission::factory()->create([
                'project_role_id' => $customProjectRole->project_role_id,
                'project_permission_id' => $parentPermission->id,
        ]);

        ProjectRolePermission::factory()->create([
                'project_role_id' => $customProjectRole->project_role_id,
                'project_permission_id' => $childPermission->id,
        ]);

        ProjectMember::factory()->create([
            'user_id' => $user->id,
            'project_id' => $customProjectRole->project_id,
            'role_id' => $customProjectRole->project_role_id,
        ]);

        // 実行
        $result = $this->interactor->execute($user->id, $customProjectRole->project_id, $childPermission->id);

        // 検証
        $this->assertTrue($result);
    }
} 