<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Enums\UrgencyLevelEnum;

class UrgencyLevel extends Model
{
    /**
     * 複数代入可能な属性
     *
     * @var array<string>
     */
    protected $fillable = [
        'id',
        'name',
        'level',
        'description',
    ];

    /**
     * 属性のキャスト
     *
     * @var array<string, string>
     */
    protected $casts = [
        'id' => 'integer',
        'level' => UrgencyLevelEnum::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * この緊急度を持つタスク一覧を取得
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'urgency_level_id');
    }
} 