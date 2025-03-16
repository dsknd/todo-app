<?php

namespace App\Models;

use App\Casts\LocaleIdCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Locale extends Model
{
    use HasFactory;

    protected $table = 'locales';

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'language_code',
        'region_code',
        'script_code',
        'format_bcp47',
        'format_cldr',
        'format_posix',
        'name',
        'native_name',
        'date_format_short',
        'date_format_medium',
        'date_format_long',
        'time_format_short',
        'time_format_medium',
        'datetime_format_short',
        'is_active',
    ];

    protected $casts = [
        'id' => LocaleIdCast::class,
        'is_active' => 'boolean',
    ];

    /**
     * タスクステータスの翻訳を取得
     */
    public function taskStatuses(): BelongsToMany
    {
        return $this->belongsToMany(TaskStatus::class, 'task_status_translations', 'locale_id', 'task_status_id');
    }

    /**
     * アクティブなロケールを取得
     */
    public static function getActiveLocales(): Collection
    {
        return self::where('is_active', true)->get();
    }
}