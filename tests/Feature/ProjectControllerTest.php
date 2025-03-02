<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use App\Models\ProjectStatus;
use App\Models\Project;
class ProjectControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
    * @var \App\Models\User&\Illuminate\Contracts\Auth\Authenticatable
    */
    private User $user;
    private ProjectStatus $projectStatus;
    private Project $project;
    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->projectStatus = ProjectStatus::factory()->create();
        $this->project = Project::factory()
                ->for($this->user)
                ->for($this->projectStatus)
                ->create();

    }

    public function test_store_validation_error(): void
    {
        // 空のデータでPOSTリクエストを送信し、バリデーションエラーを発生させる
        $response = $this->actingAs($this->user)
                         ->postJson('/api/projects');

        // 422 Unprocessable Entity ステータスが返ることを確認
        $response->assertStatus(422);

        // TODO:レスポンスのJSONにバリデーションエラーが含まれていることを確認
    }

    public function test_store_success(): void
    {
        // データを作成
        $data = [
            'name' => 'Test Project',
            'description' => 'This is a test project',
            'is_private' => false,
        ];

        // POSTリクエストを送信
        $response = $this->actingAs($this->user)
                         ->postJson('/api/projects', $data);

        // ログでレスポンスを確認
        \Log::info($response->getContent());

        // 201 Created ステータスが返ることを確認
        $response->assertStatus(Response::HTTP_CREATED);

        // TODO:レスポンスのJSONにプロジェクトが含まれていることを確認
    }

    public function test_index_success(): void
    {
        // GETリクエストを送信
        $response = $this->actingAs($this->user)
                         ->getJson('/api/projects');

        // 200 OK ステータスが返ることを確認
        $response->assertStatus(Response::HTTP_OK);

        // TODO:レスポンスのJSONにプロジェクトが含まれていることを確認
    }

    public function test_update_success(): void
    {
        // データを更新
        $data = [
            'name' => 'Updated Project',
            'description' => 'This is an updated project',
            'is_private' => true,
        ];

        // PUTリクエストを送信
        $response = $this->actingAs($this->user)
                         ->putJson('/api/projects/' . $this->project->id, $data);

        // 200 OK ステータスが返ることを確認
        $response->assertOk();

        // レスポンスJson構造を確認
        $response->assertJsonStructure([
            'message',
            'project' => [
                    'id',
                    'name',
                    'description',
                    'project_status_id',
                    'is_private',
                    'created_at',
                    'updated_at'
                ]
            ])
            ->assertJsonPath('project.name', 'Updated Project');

        // データベースに更新されていることを確認
        $this->assertDatabaseHas('projects', [
            'id' => $this->project->id,
            'name' => 'Updated Project',
        ]);
    }

    public function test_destroy_success(): void
    {
        // DELETEリクエストを送信
        $response = $this->actingAs($this->user)
                         ->deleteJson('/api/projects/' . $this->project->id);

        // 200 OK ステータスが返ることを確認
        $response->assertNoContent();

        // データベースに削除されていることを確認
        $this->assertDatabaseMissing('projects', [
            'id' => $this->project->id,
        ]);
    }
}


