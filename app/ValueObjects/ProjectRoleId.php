<?php

namespace App\ValueObjects;

use InvalidArgumentException;
use JsonSerializable;

class ProjectRoleId implements JsonSerializable
{
    private int $value;

    /**
     * @param int $value
     * @throws InvalidArgumentException IDが無効な場合
     */
    public function __construct(int $value)
    {
        if ($value <= 0) {
            throw new InvalidArgumentException('プロジェクトロールIDは正の整数である必要があります');
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
     * @param ProjectRoleId $other
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
     * 文字列からProjectRoleIdを作成
     *
     * @param string $id
     * @return self
     */
    public static function fromString(string $id): self
    {
        if (!ctype_digit($id)) {
            throw new InvalidArgumentException('プロジェクトロールIDは数値である必要があります');
        }
        
        return new self((int) $id);
    }

    /**
     * オブジェクトを整数に変換する際に呼び出されるマジックメソッド
     *
     * @return int
     */
    public function __toInt(): int
    {
        return $this->getValue();
    }
}