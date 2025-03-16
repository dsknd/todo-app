<?php

namespace App\ValueObjects;

use InvalidArgumentException;
use JsonSerializable;

class ProjectRoleNumber implements JsonSerializable
{
    private int $value;

    /**
     * @param int $value
     * @throws InvalidArgumentException 番号が無効な場合
     */
    public function __construct(int $value)
    {
        if ($value <= 0) {
            throw new InvalidArgumentException('プロジェクトロール番号は正の整数である必要があります');
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
     * @param ProjectRoleNumber $other
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

    /**
     * 文字列からProjectRoleNumberを作成
     *
     * @param string $number
     * @return self
     */
    public static function fromString(string $number): self
    {
        if (!ctype_digit($number)) {
            throw new InvalidArgumentException('プロジェクトロール番号は数値である必要があります');
        }
        
        return new self((int) $number);
    }
}