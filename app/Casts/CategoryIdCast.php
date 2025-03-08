<?php

namespace App\Casts;

use App\ValueObjects\CategoryId;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class CategoryIdCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        if ($value === null) {
            return null;
        }
        
        return new CategoryId((int) $value);
    }

    public function set($model, string $key, $value, array $attributes)
    {
        if ($value instanceof CategoryId) {
            return [$key => $value->getValue()];
        }

        if (is_int($value) || (is_string($value) && ctype_digit($value))) {
            return [$key => (int) $value];
        }

        return [$key => null];
    }
}