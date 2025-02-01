<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class TaskStatusTranslation extends Pivot
{
    /**
     * テーブル名
     *
     * @var string
     */
    protected $table = 'task_status_translations';

    /**
     * IDを自動増分するかどうか
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * タイムスタンプを使用するかどうか
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * 複数代入可能な属性
     *
     * @var array<string>
     */
    protected $fillable = [
        'task_status_id',
        'locale',
        'name',
        'description',
    ];

    /**
     * 属性のキャスト
     *
     * @var array<string, string>
     */
    protected $casts = [
        'task_status_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * タスクステータスを取得
     */
    public function taskStatus(): BelongsTo
    {
        return $this->belongsTo(TaskStatus::class);
    }

    /**
     * ロケールを取得
     */
    public function locale(): BelongsTo
    {
        return $this->belongsTo(Locale::class, 'locale', 'id');
    }
} 