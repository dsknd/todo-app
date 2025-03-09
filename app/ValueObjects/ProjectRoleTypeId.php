<?php

namespace App\ValueObjects;

use InvalidArgumentException;
use JsonSerializable;

class ProjectRoleTypeId implements JsonSerializable
{
    private int $value;

    /**
     * コンストラクタ
     *
     * @param int $value プロジェクトロールタイプID
     * @throws InvalidArgumentException IDが正の整数でない場合
     */
    public function __construct(int $value)
    {
        if ($value <= 0) {
            throw new InvalidArgumentException('プロジェクトロールタイプIDは正の整数である必要があります。');
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
     * 他のProjectRoleTypeIdと等しいかどうかを判定
     *
     * @param ProjectRoleTypeId $other 比較対象
     * @return bool
     */
    public function equals(ProjectRoleTypeId $other): bool
    {
        return $this->value === $other->getValue();
    }

    /**
     * 文字列表現を取得
     *
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->value;
    }

    /**
     * JSON シリアライズ時の挙動を定義
     *
     * @return int
     */
    public function jsonSerialize(): int
    {
        return $this->value;
    }

    /**
     * 文字列からProjectRoleTypeIdを生成
     *
     * @param string $id 文字列ID
     * @return self
     * @throws InvalidArgumentException IDが数値でない場合
     */
    public static function fromString(string $id): self
    {
        if (!is_numeric($id)) {
            throw new InvalidArgumentException('プロジェクトロールタイプIDは数値である必要があります。');
        }

        return new self((int) $id);
    }
}