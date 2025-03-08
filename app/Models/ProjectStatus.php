<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\ValueObjects\ProjectStatusId;
use App\Casts\ProjectStatusIdCast;

class ProjectStatus extends Model
{
    use HasFactory;

    protected $table = 'project_statuses';

    protected $primaryKey = 'id';

    // オートインクリメントを無効にする
    public $incrementing = false;

    // 主キーのデータ型を数値として扱う（もし文字列の場合は 'string' にする）
    protected $keyType = 'int';

    protected $fillable = [
        'id',
        'key',
    ];

    protected $casts = [
        'id' => ProjectStatusIdCast::class,
    ];

    /**
     * このステータスを持つプロジェクトとの関連
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'project_status_id');
    }
}