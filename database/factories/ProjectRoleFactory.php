<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\ProjectRole;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProjectRole>
 */
class ProjectRoleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProjectRole::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'project_id' => Project::factory(),
            'name' => $this->faker->unique()->word(),
            'description' => $this->faker->sentence(),
            'user_id' => User::factory(),
        ];
    }

    /**
     * プロジェクト管理者ロールを作成
     */
    public function admin(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Admin',
                'description' => 'プロジェクト管理者ロール',
            ];
        });
    }

    /**
     * プロジェクトメンバーロールを作成
     */
    public function member(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Member',
                'description' => '一般メンバーロール',
            ];
        });
    }

    /**
     * プロジェクト閲覧者ロールを作成
     */
    public function viewer(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Viewer',
                'description' => '閲覧のみ可能なロール',
            ];
        });
    }

    /**
     * 編集権限を持つロールを作成
     */
    public function canEdit(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'can_edit' => true,
            ];
        });
    }

    /**
     * 特定のプロジェクト用のロールを作成
     */
    public function forProject(Project $project): self
    {
        return $this->state(function (array $attributes) use ($project) {
            return [
                'project_id' => $project->id,
            ];
        });
    }

    /**
     * 特定のユーザーが作成したロールを作成
     */
    public function createdBy(User $user): self
    {
        return $this->state(function (array $attributes) use ($user) {
            return [
                'user_id' => $user->id,
            ];
        });
    }
}