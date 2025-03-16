<?php

namespace App\ValueObjects;

use InvalidArgumentException;
use JsonSerializable;

class PriorityId implements JsonSerializable
{
    private int $value;

    /**
     * @param int $value
     * @throws InvalidArgumentException IDが無効な場合
     */
    public function __construct(int $value)
    {
        if ($value <= 0) {
            throw new InvalidArgumentException('優先度IDは正の整数である必要があります');
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
     * @param PriorityId $other
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
     * JSONシリアライズ時に呼ばれるメソッド
     *
     * @return mixed
     */
    public function jsonSerialize(): mixed
    {
        return $this->value;
    }
}