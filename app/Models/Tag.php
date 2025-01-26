<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'color',
        'is_personal',
        'user_id',
        'project_id',
        'parent_tag_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_personal' => 'boolean',
    ];

    /**
     * 親タグとの関連
     */
    public function parentTag(): BelongsTo
    {
        return $this->belongsTo(Tag::class, 'parent_tag_id');
    }

    /**
     * 子タグとの関連
     */
    public function childTags(): HasMany
    {
        return $this->hasMany(Tag::class, 'parent_tag_id');
    }

    /**
     * 作成者/所有者との関連
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * プロジェクトとの関連
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * タグ付けされたタスクとの関連
     */
    public function tasks(): MorphToMany
    {
        return $this->morphedByMany(Task::class, 'taggable', 'tag_assignments');
    }

    /**
     * タグ付けされたプロジェクトとの関連
     */
    public function projects(): MorphToMany
    {
        return $this->morphedByMany(Project::class, 'taggable', 'tag_assignments');
    }

    /**
     * タグ付けされたマイルストーンとの関連
     */
    public function milestones(): MorphToMany
    {
        return $this->morphedByMany(ProjectMilestone::class, 'taggable', 'tag_assignments');
    }

    /**
     * タグの全階層パスを取得
     * 
     * @return array<Tag> 親タグから順に並んだ配列
     */
    public function getHierarchyPath(): array
    {
        $path = [$this];
        $current = $this;

        while ($current->parentTag) {
            $current = $current->parentTag;
            array_unshift($path, $current);
        }

        return $path;
    }

    /**
     * タグの階層レベルを取得
     */
    public function getLevel(): int
    {
        $level = 0;
        $current = $this;

        while ($current->parentTag) {
            $level++;
            $current = $current->parentTag;
        }

        return $level;
    }

    /**
     * タグが特定のプロジェクトに属しているかどうかを確認
     */
    public function belongsToProject(int $projectId): bool
    {
        return !$this->is_personal && $this->project_id === $projectId;
    }

    /**
     * タグが特定のユーザーに属しているかどうかを確認
     */
    public function belongsToUser(int $userId): bool
    {
        return $this->is_personal && $this->user_id === $userId;
    }

    /**
     * タグの使用回数を取得
     */
    public function getUsageCount(): int
    {
        return TagAssignment::where('tag_id', $this->id)->count();
    }

    /**
     * タグの検証
     * 
     * @throws \InvalidArgumentException 検証エラーの場合
     */
    public function validate(): void
    {
        // 作成者/所有者が存在することを確認
        if (!$this->user) {
            throw new \InvalidArgumentException('User does not exist');
        }

        // プロジェクトタグの場合、プロジェクトが存在することを確認
        if (!$this->is_personal && !$this->project) {
            throw new \InvalidArgumentException('Project does not exist');
        }

        // 個人タグの場合、プロジェクトIDが設定されていないことを確認
        if ($this->is_personal && $this->project_id) {
            throw new \InvalidArgumentException('Personal tag cannot belong to a project');
        }

        // 親タグが存在する場合、同じ種類（個人/プロジェクト）のタグであることを確認
        if ($this->parent_tag_id) {
            if ($this->parentTag->is_personal !== $this->is_personal) {
                throw new \InvalidArgumentException('Parent tag must be of the same type');
            }

            if (!$this->is_personal && $this->parentTag->project_id !== $this->project_id) {
                throw new \InvalidArgumentException('Parent tag must belong to the same project');
            }
        }
    }
}
