<?php

namespace App\ValueObjects;

use InvalidArgumentException;
use JsonSerializable;
use App\Enums\ProjectStatusEnum;

class ProjectStatusId implements JsonSerializable
{
    private int $value;

    /**
     * @param int $value
     * @throws InvalidArgumentException IDが無効な場合
     */
    public function __construct(int $value)
    {
        if ($value <= 0) {
            throw new InvalidArgumentException('プロジェクトステータスIDは正の整数である必要があります');
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
     * @param ProjectStatusId $other
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
     * ProjectStatusEnumからProjectStatusIdを作成
     *
     * @param ProjectStatusEnum $enum
     * @return self
     */
    public static function fromEnum(ProjectStatusEnum $enum): self
    {
        return new self($enum->value);
    }

    /**
     * ProjectStatusIdからProjectStatusEnumを取得
     *
     * @return ProjectStatusEnum|null
     */
    public function toEnum(): ?ProjectStatusEnum
    {
        return match($this->value) {
            1 => ProjectStatusEnum::PLANNING,
            2 => ProjectStatusEnum::IN_PROGRESS,
            3 => ProjectStatusEnum::COMPLETED,
            4 => ProjectStatusEnum::ON_HOLD,
            5 => ProjectStatusEnum::CANCELLED,
            default => null,
        };
    }
}