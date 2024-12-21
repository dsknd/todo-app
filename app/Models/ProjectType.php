<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectType extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'is_default', 'is_primitive'];

    const DEFAULT_TYPE_NAME = '未分類';

    /**
     * デフォルトのProjectTypeを取得するスコープ
     */
    public function scopeDefault($query, $userId)
    {
        return $query->where('user_id', $userId)->where('is_default', true);
    }

    /**
     * このProjectTypeをデフォルトに設定
     */
    public function setAsDefault()
    {
        // ユーザーの他のデフォルトを解除
        self::where('user_id', $this->user_id)->update(['is_default' => false]);

        // このProjectTypeをデフォルトに設定
        $this->update(['is_default' => true]);
    }


    public static function boot()
    {
        parent::boot();

        static::deleting(function ($projectType) {
            if ($projectType->is_primitive) {
                throw new \Exception('This project type cannot be deleted.');
            }
        });
    }
}