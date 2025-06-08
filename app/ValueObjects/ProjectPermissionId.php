<?php

namespace App\ValueObjects;

use InvalidArgumentException;
use JsonSerializable;
use App\Enums\PermissionEnum;
use App\Enums\ProjectPermissionEnum;

class ProjectPermissionId implements JsonSerializable
{
    private int $value;

    /**
     * コンストラクタ
     *
     * @param int $value 権限ID
     * @throws InvalidArgumentException IDが正の整数でない場合
     */
    public function __construct(int $value)
    {
        if ($value <= 0) {
            throw new InvalidArgumentException('権限IDは正の整数である必要があります。');
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
     * 他のPermissionIdと等しいかどうかを判定
     *
     * @param self $other 比較対象
     * @return bool
     */
    public function equals(self $other): bool
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
     * 整数値を取得
     *
     * @return int
     */
    public function toInt(): int
    {
        return $this->value;
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

    public static function from(int | string | ProjectPermissionEnum $value ): self
    {
        if ($value instanceof ProjectPermissionEnum) {
            return self::fromEnum($value);
        }

        if (is_int($value)) {
            return new self($value);
        }

        if (is_string($value)) {
            return self::fromString($value);
        }

        throw new InvalidArgumentException('権限IDは数値または文字列である必要があります。');
    }

    /**
     * 文字列からPermissionIdを生成
     *
     * @param string $id 文字列ID
     * @return self
     * @throws InvalidArgumentException IDが数値でない場合
     */
    private function fromString(string $id): self
    {
        if (!is_numeric($id)) {
            throw new InvalidArgumentException('権限IDは数値である必要があります。');
        }

        return new self((int) $id);
    }

    /**
     * EnumからPermissionIdを生成
     *
     * @param ProjectPermissionEnum $permissionEnum
     * @return self
     */
    private function fromEnum(ProjectPermissionEnum $permissionEnum): self
    {
        if (!is_numeric($permissionEnum->value)) {
            throw new InvalidArgumentException('権限IDは数値である必要があります。');
        }

        return new self((int) $permissionEnum->value);
    }
} 