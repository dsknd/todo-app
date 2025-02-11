<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Priority extends Model
{
    use HasFactory;

    protected $table = 'priorities';

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'key',
        'priority_value'
    ];

    /**
     * このプライオリティを持つタスク
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    // /**
    //  * プライオリティの翻訳
    //  */
    // public function translations(): HasMany
    // {
    //     return $this->hasMany(PriorityTranslation::class);
    // }

    /**
     * 指定された言語でのプライオリティ名を取得
     */
    public function getNameByLocale(string $locale): ?string
    {
        return $this->translations()
            ->where('locale_id', Locale::where('key', $locale)->first()?->id)
            ->first()?->name;
    }
} 