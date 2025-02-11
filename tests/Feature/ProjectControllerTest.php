<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Contracts\Auth\Authenticatable;
use Symfony\Component\HttpFoundation\Response;
use App\Models\ProjectStatus;
use App\Models\Project;
class ProjectControllerTest extends TestCase
{
    use RefreshDatabase;

    private Authenticatable $user;
    private ProjectStatus $projectStatus;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->projectStatus = ProjectStatus::factory()->create();
        \Log::info('projectStatus: ' . $this->projectStatus->id);
        \Log::info('user: ' . $this->user->id);

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
        // データを作成
        \Log::info('projectStatus: ' . $this->projectStatus->id);
        \Log::info('user: ' . $this->user->id);
        $project = Project::factory()
            ->for($this->user)
            ->for($this->projectStatus)
            ->create();

        // GETリクエストを送信
        $response = $this->actingAs($this->user)
                         ->getJson('/api/projects');

        // 200 OK ステータスが返ることを確認
        $response->assertStatus(Response::HTTP_OK);

        // TODO:レスポンスのJSONにプロジェクトが含まれていることを確認
    }
}
