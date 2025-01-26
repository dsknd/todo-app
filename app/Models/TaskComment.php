<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaskComment extends Model
{
    protected $fillable = [
        'task_id',
        'user_id',
        'content',
        'parent_id',
    ];

    /**
     * タスクとの関連
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * 作成者との関連
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 親コメントとの関連
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(TaskComment::class, 'parent_id');
    }

    /**
     * 返信コメントとの関連
     */
    public function replies(): HasMany
    {
        return $this->hasMany(TaskComment::class, 'parent_id');
    }

    /**
     * コメントの階層レベルを取得
     */
    public function getLevel(): int
    {
        $level = 0;
        $current = $this;

        while ($current->parent) {
            $level++;
            $current = $current->parent;
        }

        return $level;
    }

    /**
     * コメントの全階層パスを取得
     * 
     * @return array<TaskComment> 親コメントから順に並んだ配列
     */
    public function getHierarchyPath(): array
    {
        $path = [$this];
        $current = $this;

        while ($current->parent) {
            $current = $current->parent;
            array_unshift($path, $current);
        }

        return $path;
    }

    /**
     * 返信を追加
     */
    public function addReply(string $content, User $user): self
    {
        return $this->replies()->create([
            'task_id' => $this->task_id,
            'user_id' => $user->id,
            'content' => $content,
        ]);
    }

    /**
     * ルートコメントかどうかを判定
     */
    public function isRoot(): bool
    {
        return $this->parent_id === null;
    }

    /**
     * 返信を持つかどうかを判定
     */
    public function hasReplies(): bool
    {
        return $this->replies()->exists();
    }

    /**
     * 返信数を取得
     */
    public function getReplyCount(): int
    {
        return $this->replies()->count();
    }

    /**
     * 全返信数を取得（孫コメントも含む）
     */
    public function getTotalReplyCount(): int
    {
        $count = 0;
        foreach ($this->replies as $reply) {
            $count += 1 + $reply->getTotalReplyCount();
        }
        return $count;
    }
}
