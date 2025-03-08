<?php

namespace App\ValueObjects;

use InvalidArgumentException;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class CategoryId implements CastsAttributes
{
    private int $value;

    /**
     * @param int $value
     * @throws InvalidArgumentException IDが無効な場合
     */
    public function __construct(int $value)
    {
        if ($value <= 0) {
            throw new InvalidArgumentException('カテゴリIDは正の整数である必要があります');
        }

        $this->value = $value;
    }

    /**
     * 値を取得
     *
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * 等価性の比較
     *
     * @param CategoryId $other
     * @return bool
     */
    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }

    /**
     * 文字列表現
     *
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->value;
    }

    /**
     * データベースの値をCategoryIdオブジェクトに変換
     *
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return CategoryId|null
     */
    public function get($model, string $key, $value, array $attributes)
    {
        // nullの場合はnullを返す
        if ($value === null) {
            return null;
        }
        
        // 既にCategoryIdインスタンスの場合はそのまま返す
        if ($value instanceof self) {
            return $value;
        }
        
        // 整数値に変換してからインスタンスを作成
        return new self((int) $value);
    }

    /**
     * CategoryIdオブジェクトをデータベースの値に変換
     *
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return mixed
     */
    public function set($model, string $key, $value, array $attributes)
    {
        if ($value instanceof self) {
            return [$key => $value->getValue()];
        }

        if (is_int($value) || (is_string($value) && ctype_digit($value))) {
            return [$key => (int) $value];
        }

        return [$key => null];
    }
}