<?php

namespace App\Casts;

use App\ValueObjects\ProjectMemberCreatedAt;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;
use InvalidArgumentException;

class ProjectMemberCreatedAtCast implements CastsAttributes
{
    /**
     * データベースの値をProjectMemberCreatedAtオブジェクトに変換
     *
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return ProjectMemberCreatedAt|null
     */
    public function get($model, string $key, $value, array $attributes)
    {
        if ($value === null) {
            return null;
        }
        
        return ProjectMemberCreatedAt::from($value);
    }

    /**
     * ProjectMemberCreatedAtオブジェクトをデータベースの値に変換
     *
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return mixed
     */
    public function set($model, string $key, $value, array $attributes)
    {
        if ($value instanceof ProjectMemberCreatedAt) {
            return [$key => $value->getValue()];
        }

        if (is_string($value) || $value instanceof DateTimeInterface) {
            return [$key => ProjectMemberCreatedAt::from($value)->getValue()];
        }

        throw new InvalidArgumentException(
            sprintf('Cannot cast value of type %s to ProjectMemberCreatedAt', gettype($value))
        );
    }
}