<?php

namespace App\ValueObjects;

use InvalidArgumentException;

/**
 * プロジェクトメンバーID
 */
final class ProjectMemberId
{
    /**
     * コンストラクタ
     *
     * @param int $value
     */
    private function __construct(
        private readonly int $value
    ) {
        if ($value <= 0) {
            throw new InvalidArgumentException('ProjectMemberId must be a positive integer');
        }
    }

    /**
     * 値からインスタンスを作成
     *
     * @param int|ProjectMemberId $value
     * @return self
     */
    public static function from(int|ProjectMemberId $value): self
    {
        if ($value instanceof self) {
            return $value;
        }
        
        return new self($value);
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
     * 等価性をチェック
     *
     * @param ProjectMemberId $other
     * @return bool
     */
    public function equals(ProjectMemberId $other): bool
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
} 