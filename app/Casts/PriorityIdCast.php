<?php

namespace App\Casts;

use App\ValueObjects\PriorityId;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class PriorityIdCast implements CastsAttributes
{
    /**
     * データベースの値をPriorityIdオブジェクトに変換
     *
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return PriorityId|null
     */
    public function get($model, string $key, $value, array $attributes)
    {
        if ($value === null) {
            return null;
        }
        
        return new PriorityId((int) $value);
    }

    /**
     * PriorityIdオブジェクトをデータベースの値に変換
     *
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return mixed
     */
    public function set($model, string $key, $value, array $attributes)
    {
        if ($value instanceof PriorityId) {
            return [$key => $value->getValue()];
        }

        if (is_int($value) || (is_string($value) && ctype_digit($value))) {
            return [$key => (int) $value];
        }

        return [$key => null];
    }
}