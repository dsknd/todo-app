<?php

namespace App\Casts;

use App\ValueObjects\LocaleId;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

class LocaleIdCast implements CastsAttributes
{
    /**
     * 値をキャスト
     *
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return LocaleId|null
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): ?LocaleId
    {
        if (is_null($value)) {
            return null;
        }

        return new LocaleId((int) $value);
    }

    /**
     * 値を保存用にキャスト
     *
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return int|null
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): ?int
    {
        if (is_null($value)) {
            return null;
        }

        if ($value instanceof LocaleId) {
            return $value->getValue();
        }

        if (is_int($value) || (is_string($value) && is_numeric($value))) {
            return (int) $value;
        }

        throw new InvalidArgumentException('ロケールIDは整数またはLocaleIdオブジェクトである必要があります。');
    }
} 