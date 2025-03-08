<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use App\Enums\LanguageCodeStandardEnum;
class Locale extends Model
{
    protected $fillable = [
        'id',
        'code_iso_639_1',
        'code_ietf_bcp_47',
        'name',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * タスクステータスの翻訳を取得
     */
    public function taskStatuses(): BelongsToMany
    {
        return $this->belongsToMany(TaskStatus::class, 'task_status_translations', 'locale_id', 'task_status_id');
    }

    public static function getActiveLocales(): Collection
    {
        return self::where('is_active', true)->get();
    }
}