<?php

namespace Tests\Feature;

use App\Enums\DefaultProjectRoleEnum;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Project;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Models\ProjectMember;
use App\ValueObjects\ProjectRoleId;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\ProjectPermissionSeeder;
use Database\Seeders\DefaultProjectRoleSeeder;
use Database\Seeders\ProjectStatusSeeder;
use Database\Seeders\ProjectRoleTypeSeeder;
use Database\Seeders\DefaultProjectPermissionSeeder;

class ProjectControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
    * @var Authenticatable
    */
    private User $user;
    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();

        // シーダーの実行順序を確認
        $this->seed([
            PermissionSeeder::class,
            ProjectPermissionSeeder::class,
            ProjectRoleTypeSeeder::class,
            DefaultProjectRoleSeeder::class,
            DefaultProjectPermissionSeeder::class,
            ProjectStatusSeeder::class,
        ]);


    }

    public function test_index_success(): void
    {
        // テストデータの準備
        $project = Project::factory()->create();

        ProjectMember::factory()->create([
            'project_id' => $project->id,
            'user_id' => $this->user->id,
            'role_id' => new ProjectRoleId(DefaultProjectRoleEnum::OWNER->value),
        ]);

        // GETリクエストを送信
        $response = $this->actingAs($this->user)
                         ->getJson('/api/projects');

        // 200 OK ステータスが返ることを確認
        $response->assertStatus(Response::HTTP_OK);

        // レスポンスのJSON構造を確認
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'description',
                    'is_private',
                    'status' => [
                        'id',
                        'name'
                    ],
                    'owner' => [
                        'id',
                        'name'
                    ],
                    'planned_start_date',
                    'planned_end_date',
                    'actual_start_date',
                    'actual_end_date',
                    'created_at',
                    'updated_at'
                ]
            ]
        ]);
    }

    public function test_index_unauthorized(): void
    {
        // 未認証のユーザーでGETリクエストを送信
        $response = $this->getJson('/api/projects');

        // 401 Unauthorized ステータスが返ることを確認
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_store_success(): void
    {
        // プロジェクトの作成
        $response = $this->actingAs($this->user)
                         ->postJson('/api/projects', [
                            'name' => 'Test Project',
                            'description' => 'Test Description',
                            'is_private' => false,
                            'planned_start_date' => '2024-01-01',
                            'planned_end_date' => '2024-12-31',
                        ]);
        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'description',
                'is_private',
                'status' => [
                    'id',
                    'name'
                ],
                'owner' => [
                    'id',
                    'name'
                ],
                'planned_start_date',
                'planned_end_date',
                'actual_start_date',
                'actual_end_date',
                'created_at',
                'updated_at'
            ]
        ]);
    }

    public function test_store_validation_error(): void
    {
        $response = $this->actingAs($this->user)
                         ->postJson('/api/projects', [
                            'name' => '',
                        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertHeader('Content-Type', 'application/problem+json');
        $response->assertJsonStructure([
            'type',
            'title',
            'status',
            'errors' => [
                '*' => [
                    'detail',
                    'pointer'
                ]
            ]
        ]);
    }

    // ユーザが同じ名前のプロジェクトを作成しようとした場合、500エラーが返ることを確認
    public function test_store_duplicate_project_name(): void
    {
        $firstResponse = $this->actingAs($this->user)
                         ->postJson('/api/projects', [
                            'name' => 'Test Project',
                            'description' => 'Test Description',
                            'is_private' => false,
                            'planned_start_date' => '2024-01-01',
                            'planned_end_date' => '2024-12-31',
                        ]);

        $secondResponse = $this->actingAs($this->user)
                         ->postJson('/api/projects', [
                            'name' => 'Test Project',
                            'description' => 'Test Description',
                            'is_private' => false,
                            'planned_start_date' => '2024-01-01',
                            'planned_end_date' => '2024-12-31',
                        ]);

        $firstResponse->assertStatus(Response::HTTP_CREATED);
        $secondResponse->assertStatus(Response::HTTP_INTERNAL_SERVER_ERROR);
        $secondResponse->assertHeader('Content-Type', 'application/problem+json');
        $secondResponse->assertJsonStructure([
            'type',
            'title',
            'status',
            'detail',
            'instance',
        ]);
    }

    public function test_update_success(): void
    {
        $project = Project::factory()->create();

        ProjectMember::factory()->create([
            'project_id' => $project->id,
            'user_id' => $this->user->id,
            'role_id' => new ProjectRoleId(DefaultProjectRoleEnum::OWNER->value),
        ]);

        $response = $this->actingAs($this->user)
                         ->putJson('/api/projects/' . $project->id, [
                            'name' => 'Updated Project',
                            'description' => 'Updated Description',
                         ]);

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'description',
                'is_private',
                'status' => [
                    'id',
                    'name'
                ],
                'owner' => [
                    'id',
                    'name'
                ],
                'planned_start_date',
                'planned_end_date',
                'actual_start_date',
                'actual_end_date',
                'created_at',
                'updated_at'
            ]
        ]);
    }

    public function test_destroy_success(): void
    {
        $project = Project::factory()->create();
        $response = $this->actingAs($this->user)
                         ->deleteJson('/api/projects/' . $project->id);
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function test_destroy_project_not_found(): void
    {
        $response = $this->actingAs($this->user)
                         ->deleteJson('/api/projects/' . 9999);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertHeader('Content-Type', 'application/problem+json');
        $response->assertJsonStructure([
            'type',
            'title',
            'status',
            'detail',
            'instance',
        ]);
    }
}


