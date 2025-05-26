<?php

namespace App\ValueObjects;

use DateTimeImmutable;
use JsonSerializable;
use InvalidArgumentException;
use DateTimeInterface;
use Illuminate\Support\Carbon;
use DateTime;

class ProjectMemberCreatedAt implements JsonSerializable
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
     * 様々な日時形式からインスタンスを作成
     *
     * @param DateTimeInterface|string $value
     * @return self
     */
    public static function from(DateTimeInterface|string $value): self
    {
        if ($value instanceof DateTimeImmutable) {
            return new self($value);
        }

        if ($value instanceof Carbon) {
            return new self($value->toDateTimeImmutable());
        }

        if ($value instanceof DateTime) {
            return new self(DateTimeImmutable::createFromInterface($value));
        }

        if ($value instanceof DateTimeInterface) {
            return new self(DateTimeImmutable::createFromInterface($value));
        }

        if (is_string($value)) {
            return new self(new DateTimeImmutable($value));
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