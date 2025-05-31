<?php

namespace App\Casts;

use App\ValueObjects\ProjectMemberId;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class ProjectMemberIdCast implements CastsAttributes
{
    /**
     * データベースの値をProjectMemberIdオブジェクトに変換
     *
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return ProjectMemberId|null
     */
    public function get($model, string $key, $value, array $attributes)
    {
        if ($value === null) {
            return null;
        }
        
        // 既にProjectMemberIdのインスタンスの場合はそのまま返す
        if ($value instanceof ProjectMemberId) {
            return $value;
        }
        
        return ProjectMemberId::from((int) $value);
    }

    /**
     * ProjectMemberIdオブジェクトをデータベースの値に変換
     *
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return mixed
     */
    public function set($model, string $key, $value, array $attributes)
    {
        if ($value instanceof ProjectMemberId) {
            return [$key => $value->getValue()];
        }

        if (is_int($value) || (is_string($value) && ctype_digit($value))) {
            return [$key => (int) $value];
        }

        return [$key => null];
    }
}
