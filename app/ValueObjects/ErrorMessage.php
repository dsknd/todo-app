<?php

namespace App\ValueObjects;

use InvalidArgumentException;
use JsonSerializable;
use App\Enums\ErrorMessageEnum;

class ErrorMessage implements JsonSerializable
{
    private string $value;

    /**
     * コンストラクタ
     *
     * @param string $value エラーメッセージ
     * @throws InvalidArgumentException エラーメッセージが正の整数でない場合
     */
    public function __construct(string $value)
    {
        if (empty($value)) {
            throw new InvalidArgumentException('エラーメッセージは空である必要があります。');
        }

        $this->value = $value;
    }

    /**
     * 値を取得
     *
     * @return int
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * 他のErrorMessageと等しいかどうかを判定
     *
     * @param ErrorMessage $other 比較対象
     * @return bool
     */
    public function equals(ErrorMessage $other): bool
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
     * @return string
     */
    public function jsonSerialize(): string
    {
        return $this->value;
    }

    /**
     * 文字列からErrorMessageを生成
     *
     * @param string $id 文字列エラーメッセージ
     * @return self
     * @throws InvalidArgumentException エラーメッセージが文字列でない場合
     */
    public static function fromString(string $id): self
    {
        if (!is_string($id)) {
            throw new InvalidArgumentException('エラーメッセージは文字列である必要があります。');
        }

        return new self($id);
    }

    /**
     * EnumからErrorMessageを生成
     *
     * @param ErrorMessageEnum $enum エラーメッセージのEnum
     * @return self
     */
    public static function fromEnum(ErrorMessageEnum $enum): self
    {
        return new self($enum->value);
    }
} 