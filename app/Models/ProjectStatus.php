<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProjectStatus extends Model
{
    protected $fillable = [
        'name',
        'description',
        'color',         // ステータスの表示色（例：#FF0000）
        'display_order', // 表示順序
        'is_default',    // デフォルトステータスかどうか
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_default' => 'boolean',
        'display_order' => 'integer',
    ];

    /**
     * このステータスを持つプロジェクトとの関連
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'project_status_id');
    }

    /**
     * デフォルトのプロジェクトステータスを取得
     */
    public static function getDefault(): ?self
    {
        return static::where('is_default', true)->first();
    }
}
