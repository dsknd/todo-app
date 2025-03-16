<?php

namespace Tests\Unit\Repositories;

use App\Models\Permission;
use App\Models\ProjectPermission;
use App\Repositories\Interfaces\PermissionRepository;
use App\ValueObjects\PermissionId;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Group;
use Tests\TestCase;
use Tests\Helpers\PermissionHierarchySetup;

#[Group('repository')]
#[Group('permission')]
class PermissionRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected PermissionRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = app(PermissionRepository::class);
    }

    public function test_it_can_find_by_id()
    {
        // 準備
        $permission = Permission::factory()->create([
            'scope' => 'users:read',
            'resource' => 'users',
            'action' => 'read'
        ]);

        // 実行
        $foundPermission = $this->repository->findById($permission->id);

        // 検証
        $this->assertNotNull($foundPermission);
        $this->assertEquals($permission->id, $foundPermission->id);
        $this->assertEquals('users:read', $foundPermission->scope);
        $this->assertEquals('users', $foundPermission->resource);
        $this->assertEquals('read', $foundPermission->action);
    }

    public function test_it_returns_null_when_permission_not_found()
    {
        // 準備
        $permissionId = new PermissionId(999);

        // 実行
        $foundPermission = $this->repository->findById($permissionId);

        // 検証
        $this->assertNull($foundPermission);
    }

    public function test_it_can_find_by_scope()
    {
        // 準備
        Permission::factory()->count(3)->create([
            'scope' => 'users:read'
        ]);
        Permission::factory()->count(2)->create([
            'scope' => 'users:write'
        ]);

        // 実行
        $adminPermissions = $this->repository->findByScope('users:read');
        $userPermissions = $this->repository->findByScope('users:write');
        $guestPermissions = $this->repository->findByScope('users:delete');

        // 検証
        $this->assertCount(3, $adminPermissions);
        $this->assertCount(2, $userPermissions);
        $this->assertCount(0, $guestPermissions);
    }

    public function test_it_can_find_by_resource()
    {
        // 準備
        Permission::factory()->count(2)->create([
            'resource' => 'users'
        ]);
        Permission::factory()->count(3)->create([
            'resource' => 'projects'
        ]);

        // 実行
        $userResources = $this->repository->findByResource('users');
        $projectResources = $this->repository->findByResource('projects');
        $taskResources = $this->repository->findByResource('tasks');

        // 検証
        $this->assertCount(2, $userResources);
        $this->assertCount(3, $projectResources);
        $this->assertCount(0, $taskResources);
    }

    public function test_it_can_find_by_action()
    {
        // 準備
        Permission::factory()->count(2)->create([
            'action' => 'read'
        ]);
        Permission::factory()->count(3)->create([
            'action' => 'write'
        ]);

        // 実行
        $readActions = $this->repository->findByAction('read');
        $writeActions = $this->repository->findByAction('write');
        $deleteActions = $this->repository->findByAction('delete');

        // 検証
        $this->assertCount(2, $readActions);
        $this->assertCount(3, $writeActions);
        $this->assertCount(0, $deleteActions);
    }

    public function test_it_can_find_by_scope_resource_action()
    {
        // 準備
        Permission::factory()->create([
            'scope' => 'users:read',
            'resource' => 'users',
            'action' => 'read'
        ]);

        // 実行
        $permission = $this->repository->findByScopeResourceAction('users:read', 'users', 'read');
        $notFoundPermission = $this->repository->findByScopeResourceAction('users:write', 'users', 'write');

        // 検証
        $this->assertNotNull($permission);
        $this->assertEquals('users:read', $permission->scope);
        $this->assertEquals('users', $permission->resource);
        $this->assertEquals('read', $permission->action);
        $this->assertNull($notFoundPermission);
    }

    public function test_it_can_check_if_permission_exists()
    {
        // 準備
        $permission = Permission::factory()->create();
        $nonExistentId = new PermissionId(999);

        // 実行
        $exists = $this->repository->exists($permission->id);
        $notExists = $this->repository->exists($nonExistentId);

        // 検証
        $this->assertTrue($exists);
        $this->assertFalse($notExists);
    }

    public function test_it_can_find_ancestors()
    {
        // 準備
        $parent = Permission::factory()->create();
        $child = Permission::factory()->create();
        
        // クロージャーテーブルの関係をセットアップ（ヘルパー使用）
        PermissionHierarchySetup::setupParentChild($parent, $child);

        // 実行
        $ancestors = $this->repository->findAncestors($child->id);

        // 検証
        $this->assertCount(1, $ancestors);
        $this->assertEquals($parent->id->getValue(), $ancestors->first()->id->getValue());
    }

    public function test_it_can_find_descendants()
    {
        // 準備
        $parent = Permission::factory()->create();
        $child = Permission::factory()->create();
        
        // クロージャーテーブルの関係をセットアップ（ヘルパー使用）
        PermissionHierarchySetup::setupParentChild($parent, $child);

        // 実行
        $descendants = $this->repository->findDescendants($parent->id);

        // 検証
        $this->assertCount(1, $descendants);
        $this->assertEquals($child->id->getValue(), $descendants->first()->id->getValue());
    }

    public function test_it_can_check_if_permission_contains_another()
    {
        // 準備
        $parent = Permission::factory()->create();
        $child = Permission::factory()->create();
        $unrelated = Permission::factory()->create();
        
        // クロージャーテーブルの関係をセットアップ（ヘルパー使用）
        PermissionHierarchySetup::setupParentChild($parent, $child);
        
        // 無関係な権限の自己参照も追加
        \App\Models\PermissionClosure::factory()->selfReference($unrelated)->create();

        // 実行
        $contains = $this->repository->contains($parent->id, $child->id);
        $notContains = $this->repository->contains($parent->id, $unrelated->id);

        // 検証
        $this->assertTrue($contains);
        $this->assertFalse($notContains);
    }
    
    public function test_it_can_handle_complex_hierarchies()
    {
        // 準備
        $root = Permission::factory()->create();
        $parent = Permission::factory()->create();
        $child = Permission::factory()->create();
        
        // 3階層の関係をセットアップ
        PermissionHierarchySetup::setupThreeLevelHierarchy($root, $parent, $child);

        // 実行
        $rootDescendants = $this->repository->findDescendants($root->id);
        $childAncestors = $this->repository->findAncestors($child->id);

        // 検証
        $this->assertCount(2, $rootDescendants);
        $this->assertCount(2, $childAncestors);
        
        // ルートの子孫に親と子が含まれていることを確認
        $descendantIds = $rootDescendants->pluck('id')->map(function($id) {
            return $id->getValue();
        })->toArray();
        $this->assertContains($parent->id->getValue(), $descendantIds);
        $this->assertContains($child->id->getValue(), $descendantIds);
        
        // 子の祖先にルートと親が含まれていることを確認
        $ancestorIds = $childAncestors->pluck('id')->map(function($id) {
            return $id->getValue();
        })->toArray();
        $this->assertContains($root->id->getValue(), $ancestorIds);
        $this->assertContains($parent->id->getValue(), $ancestorIds);
    }

    public function test_it_can_check_if_permission_is_project_permission()
    {
        // 準備
        $projectPermission = Permission::factory()->create();
        $normalPermission = Permission::factory()->create();
        
        // project_permissionsテーブルにプロジェクト権限を登録
        ProjectPermission::factory()->create([
            'permission_id' => $projectPermission->id->getValue(),
        ]);

        // 実行
        $isProjectPermission = $this->repository->isProjectPermission($projectPermission->id);
        $isNotProjectPermission = $this->repository->isProjectPermission($normalPermission->id);

        // 検証
        $this->assertTrue($isProjectPermission);
        $this->assertFalse($isNotProjectPermission);
    }

    public function test_it_can_find_available_project_permissions()
    {
        // 準備
        $projectPermission1 = Permission::factory()->create([
            'scope' => 'projects:read',
            'resource' => 'projects',
            'action' => 'read'
        ]);
        $projectPermission2 = Permission::factory()->create([
            'scope' => 'projects:write',
            'resource' => 'projects',
            'action' => 'write'
        ]);
        $normalPermission = Permission::factory()->create([
            'scope' => 'users:read',
            'resource' => 'users',
            'action' => 'read'
        ]);

        // project_permissionsテーブルにプロジェクト権限を登録
        ProjectPermission::factory()->create([
            'permission_id' => $projectPermission1->id->getValue(),
        ]);
        ProjectPermission::factory()->create([
            'permission_id' => $projectPermission2->id->getValue(),
        ]);

        // 実行
        $availablePermissions = $this->repository->findAvailableProjectPermissions();

        // 検証
        $this->assertCount(2, $availablePermissions);
        
        // 取得した権限のIDを配列化（getValue()を呼び出さない）
        $permissionIds = $availablePermissions->pluck('id')->toArray();
        
        // プロジェクト権限が含まれていることを確認
        $this->assertContains($projectPermission1->id->getValue(), $permissionIds);
        $this->assertContains($projectPermission2->id->getValue(), $permissionIds);
        
        // 通常の権限が含まれていないことを確認
        $this->assertNotContains($normalPermission->id->getValue(), $permissionIds);
        
        // 取得した権限の属性を確認
        $this->assertTrue($availablePermissions->contains(function ($permission) {
            return $permission->scope === 'projects:read' 
                && $permission->resource === 'projects' 
                && $permission->action === 'read';
        }));
        $this->assertTrue($availablePermissions->contains(function ($permission) {
            return $permission->scope === 'projects:write' 
                && $permission->resource === 'projects' 
                && $permission->action === 'write';
        }));
    }
} 