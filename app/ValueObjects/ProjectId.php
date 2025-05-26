<?php

namespace App\ValueObjects;

use InvalidArgumentException;
use JsonSerializable;

class ProjectId implements JsonSerializable
{
    private int $value;

    /**
     * @param int $value
     * @throws InvalidArgumentException IDが無効な場合
     */
    public function __construct(int $value)
    {
        if ($value <= 0) {
            throw new InvalidArgumentException('プロジェクトIDは正の整数である必要があります');
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
     * 整数または文字列からインスタンスを作成
     *
     * @param int|string $value
     * @return self
     */
    public static function from(int|string $value): self
    {
        if (is_int($value)) {
            return self::fromInt($value);
        }
        
        if (is_string($value)) {
            return self::fromString($value);
        }

        throw new InvalidArgumentException('プロジェクトIDは整数または文字列である必要があります');
    }

    /**
     * 整数からインスタンスを作成
     *
     * @param int $value
     * @return self
     */
    public static function fromInt(int $value): self
    {
        return new self($value);
    }

    /**
     * 文字列からインスタンスを作成
     *
     * @param string $value
     * @return self
     */
    public static function fromString(string $value): self
    {
        return new self((int)$value);
    }

    /**
     * 等価性の比較
     *
     * @param ProjectId $other
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