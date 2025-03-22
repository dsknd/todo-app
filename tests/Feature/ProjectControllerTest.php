<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use App\Models\ProjectStatus;
use App\Models\Project;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Models\ProjectMember;
use App\Models\DefaultProjectRole;
use Exception;
use Mockery;
use App\Interactors\CreateProjectInteractor;

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
    }

    public function test_index_success(): void
    {
        // テストデータの準備
        $project = Project::factory()->create();
        ProjectMember::factory()->create([
            'project_id' => $project->id,
            'user_id' => $this->user->id,
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
        ProjectStatus::factory()->planning()->create();
        DefaultProjectRole::factory()->owner()->create();
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
        ProjectStatus::factory()->planning()->create();
        DefaultProjectRole::factory()->owner()->create();

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
}


