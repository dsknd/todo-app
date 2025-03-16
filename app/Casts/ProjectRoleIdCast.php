<?php

namespace App\Casts;

use App\ValueObjects\ProjectRoleId;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class ProjectRoleIdCast implements CastsAttributes
{
    /**
     * データベースの値をProjectRoleIdオブジェクトに変換
     *
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return ProjectRoleId|null
     */
    public function get($model, string $key, $value, array $attributes)
    {
        if ($value === null) {
            return null;
        }

        // 既にProjectRoleIdのインスタンスの場合はそのまま返す
        if ($value instanceof ProjectRoleId) {
            return $value;
        }
        
        return new ProjectRoleId((int) $value);
    }

    /**
     * ProjectRoleIdオブジェクトをデータベースの値に変換
     *
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return mixed
     */
    public function set($model, string $key, $value, array $attributes)
    {
        if ($value instanceof ProjectRoleId) {
            return [$key => $value->getValue()];
        }

        if (is_int($value) || (is_string($value) && ctype_digit($value))) {
            return [$key => (int) $value];
        }

        return [$key => null];
    }
}