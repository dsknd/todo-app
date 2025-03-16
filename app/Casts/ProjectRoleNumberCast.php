<?php

namespace App\Casts;

use App\ValueObjects\ProjectRoleNumber;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class ProjectRoleNumberCast implements CastsAttributes
{
    /**
     * データベースの値をProjectRoleNumberオブジェクトに変換
     *
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return ProjectRoleNumber|null
     */
    public function get($model, string $key, $value, array $attributes)
    {
        if ($value === null) {
            return null;
        }
        
        return new ProjectRoleNumber((int) $value);
    }

    /**
     * ProjectRoleNumberオブジェクトをデータベースの値に変換
     *
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return mixed
     */
    public function set($model, string $key, $value, array $attributes)
    {
        if ($value instanceof ProjectRoleNumber) {
            return [$key => $value->getValue()];
        }

        if (is_int($value) || (is_string($value) && ctype_digit($value))) {
            return [$key => (int) $value];
        }

        return [$key => null];
    }
}