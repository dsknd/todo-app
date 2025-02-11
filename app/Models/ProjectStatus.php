<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectStatus extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id',
        'key',
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
