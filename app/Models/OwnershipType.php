<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OwnershipType extends Model
{
    protected $fillable = [
        'name',
        'description',
        'is_default',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_default' => 'boolean',
    ];

    /**
     * この所有タイプを持つタスクとの関連
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    /**
     * デフォルトの所有タイプを取得
     */
    public static function getDefault(): ?self
    {
        return static::where('is_default', true)->first();
    }

    /**
     * プロジェクトタイプの所有タイプを取得
     */
    public static function getProjectType(): ?self
    {
        return static::where('name', 'project')->first();
    }

    /**
     * 個人タイプの所有タイプを取得
     */
    public static function getPersonalType(): ?self
    {
        return static::where('name', 'personal')->first();
    }

    /**
     * プロジェクトタイプかどうかを判定
     */
    public function isProjectType(): bool
    {
        return $this->name === 'project';
    }

    /**
     * 個人タイプかどうかを判定
     */
    public function isPersonalType(): bool
    {
        return $this->name === 'personal';
    }
}
