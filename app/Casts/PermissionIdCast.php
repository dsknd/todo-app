<?php

namespace App\Casts;

use App\ValueObjects\PermissionId;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class PermissionIdCast implements CastsAttributes
{
    /**
     * データベースの値をPermissionIdオブジェクトに変換
     *
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return PermissionId|null
     */
    public function get($model, string $key, $value, array $attributes)
    {
        if ($value === null) {
            return null;
        }
        
        // 既にPermissionIdのインスタンスの場合はそのまま返す
        if ($value instanceof PermissionId) {
            return $value;
        }
        
        return new PermissionId((int) $value);
    }

    /**
     * PermissionIdオブジェクトをデータベースの値に変換
     *
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return mixed
     */
    public function set($model, string $key, $value, array $attributes)
    {
        if ($value instanceof PermissionId) {
            return [$key => $value->getValue()];
        }
        
        if (is_int($value) || (is_string($value) && ctype_digit($value))) {
            return [$key => (int) $value];
        }
        
        return [$key => null];
    }
}