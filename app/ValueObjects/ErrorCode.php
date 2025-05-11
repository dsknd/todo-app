<?php

namespace App\ValueObjects;

use InvalidArgumentException;
use JsonSerializable;
use App\Enums\ErrorCodeEnum;

class ErrorCode implements JsonSerializable
{
    private int $value;

    /**
     * コンストラクタ
     *
     * @param int $value エラーコード
     * @throws InvalidArgumentException エラーコードが正の整数でない場合
     */
    public function __construct(int $value)
    {
        if ($value <= 0) {
            throw new InvalidArgumentException('エラーコードは正の整数である必要があります。');
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
     * 他のErrorCodeと等しいかどうかを判定
     *
     * @param ErrorCode $other 比較対象
     * @return bool
     */
    public function equals(ErrorCode $other): bool
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
     * 文字列からErrorCodeを生成
     *
     * @param string $id 文字列エラーコード
     * @return self
     * @throws InvalidArgumentException エラーコードが数値でない場合
     */
    public static function fromString(string $id): self
    {
        if (!is_numeric($id)) {
            throw new InvalidArgumentException('エラーコードは数値である必要があります。');
        }

        return new self((int) $id);
    }

    /**
     * EnumからErrorCodeを生成
     *
     * @param ErrorCodeEnum $enum エラーコードのEnum
     * @return self
     */
    public static function fromEnum(ErrorCodeEnum $enum): self
    {
        return new self($enum->value);
    }
} 