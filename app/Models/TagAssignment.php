<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class TagAssignment extends Pivot
{
    protected $table = 'tag_assignments';

    public $incrementing = false;

    protected $fillable = [
        'tag_id',
        'taggable_type',
        'taggable_id',
        'assigned_by',
    ];

    /**
     * タグとの関連
     */
    public function tag(): BelongsTo
    {
        return $this->belongsTo(Tag::class);
    }

    /**
     * タグ付け対象のモデルとの関連（ポリモーフィック）
     */
    public function taggable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * タグ付けを行ったユーザーとの関連
     */
    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    /**
     * タグの割り当てを検証
     * 
     * @throws \InvalidArgumentException 検証エラーの場合
     */
    public function validate(): void
    {
        // タグが存在することを確認
        if (!$this->tag) {
            throw new \InvalidArgumentException('Tag does not exist');
        }

        // タグ付け対象が存在することを確認
        if (!$this->taggable) {
            throw new \InvalidArgumentException('Taggable model does not exist');
        }

        // タグ付けを行うユーザーが存在することを確認
        if (!$this->assignedBy) {
            throw new \InvalidArgumentException('Assigner does not exist');
        }

        // プロジェクトタグの場合、同じプロジェクト内での割り当てであることを確認
        if (!$this->tag->is_personal) {
            $projectId = $this->getProjectId();
            if ($projectId !== $this->tag->project_id) {
                throw new \InvalidArgumentException('Cannot assign project tag from different project');
            }
        }

        // 個人タグの場合、タグの所有者が割り当てを行うユーザーと一致することを確認
        if ($this->tag->is_personal && $this->tag->user_id !== $this->assigned_by) {
            throw new \InvalidArgumentException('Personal tags can only be assigned by their owner');
        }
    }

    /**
     * タグ付け対象のプロジェクトIDを取得
     */
    private function getProjectId(): ?int
    {
        return match ($this->taggable_type) {
            Project::class => $this->taggable->id,
            Task::class => $this->taggable->project_id,
            ProjectMilestone::class => $this->taggable->project_id,
            default => null,
        };
    }

    /**
     * 指定されたモデルに対するタグの割り当てを取得
     */
    public static function getAssignments(Model $model): array
    {
        return static::where('taggable_type', get_class($model))
            ->where('taggable_id', $model->id)
            ->with(['tag', 'assignedBy'])
            ->get()
            ->all();
    }

    /**
     * 指定されたプロジェクトに関連するタグの割り当てを取得
     */
    public static function getProjectAssignments(int $projectId): array
    {
        return static::where(function ($query) use ($projectId) {
            $query->where('taggable_type', Project::class)
                ->where('taggable_id', $projectId)
                ->orWhereHasMorph('taggable', [Task::class, ProjectMilestone::class], function ($q) use ($projectId) {
                    $q->where('project_id', $projectId);
                });
        })
        ->with(['tag', 'assignedBy', 'taggable'])
        ->get()
        ->all();
    }
}
