<?php

namespace App\ValueObjects;

use DateTimeImmutable;
use JsonSerializable;
use InvalidArgumentException;

class ProjectMemberJoinedAt implements JsonSerializable
{
    private DateTimeImmutable $value;

    /**
     * コンストラクタ
     *
     * @param DateTimeImmutable 参加日時
     */
    private function __construct(DateTimeImmutable $value)
    {
        $this->value = $value;
    }

    /**
     * 値を取得
     *
     * @return DateTimeImmutable
     */
    public function getValue(): DateTimeImmutable
    {
        return $this->value;
    }

    /**
     * 別のインスタンスと等価か判定
     *
     * @param self $other
     * @return bool
     */
    public function equals(self $other): bool
    {
        return $this->value->format('Y-m-d H:i:s.u') === $other->value->format('Y-m-d H:i:s.u');
    }

    /**
     * 文字列に変換
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->value->format('Y-m-d H:i:s');
    }

    /**
     * JSONシリアライズ
     *
     * @return string
     */
    public function jsonSerialize(): mixed
    {
        return $this->value->format('Y-m-d H:i:s');
    }

    /**
     * DateTimeImmutableもしくは文字列からインスタンスを作成
     *
     * @param DateTimeImmutable|string $value
     * @return self
     */
    public static function from(DateTimeImmutable|string $value): self
    {
        if ($value instanceof DateTimeImmutable) {
            return self::fromDateTimeImmutable($value);
        }

        if (is_string($value)) {
            return self::fromString($value);
        }

        throw new InvalidArgumentException('Invalid value type');
    }

    /**
     * DateTimeImmutableからインスタンスを作成
     *
     * @param DateTimeImmutable $value
     * @return self
     */
    public static function fromDateTimeImmutable(DateTimeImmutable $value): self
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
        return new self(new DateTimeImmutable($value));
    }
}