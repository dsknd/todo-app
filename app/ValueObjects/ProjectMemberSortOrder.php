<?php

namespace App\ValueObjects;

use InvalidArgumentException;

final class ProjectMemberSortOrder
{
    /**
     * ソート可能なカラム一覧
     */
    private const ALLOWED_COLUMNS = [
        'joined_at',
        'user_id',
        'role_id',
        'created_at',
        'updated_at'
    ];

    /**
     * ソート方向の一覧
     */
    private const ALLOWED_DIRECTIONS = [
        'asc',
        'desc'
    ];

    /**
     * @param string $column ソート対象のカラム
     * @param string $direction ソート方向
     * @throws InvalidArgumentException
     */
    private function __construct(
        private readonly string $column,
        private readonly string $direction
    ) {
        $this->validate();
    }

    /**
     * 文字列からインスタンスを作成
     *
     * @param string $column ソート対象のカラム
     * @param string $direction ソート方向（デフォルトは昇順）
     * @throws InvalidArgumentException
     */
    public static function from(string $column, string $direction = 'asc'): self
    {
        return new self($column, strtolower($direction));
    }

    /**
     * ソート対象のカラムを取得
     */
    public function getColumn(): string
    {
        return $this->column;
    }

    /**
     * ソート方向を取得
     */
    public function getDirection(): string
    {
        return $this->direction;
    }

    /**
     * 別のインスタンスと等価か判定
     */
    public function equals(self $other): bool
    {
        return $this->column === $other->column 
            && $this->direction === $other->direction;
    }

    /**
     * カラムの妥当性を検証
     *
     * @throws InvalidArgumentException
     */
    private function validateColumn(string $column): void
    {
        if (!in_array($column, self::ALLOWED_COLUMNS)) {
            throw new InvalidArgumentException(
                "Invalid sort column: {$column}. Allowed columns are: " 
                . implode(', ', self::ALLOWED_COLUMNS)
            );
        }
    }

    /**
     * ソート方向の妥当性を検証
     *
     * @throws InvalidArgumentException
     */
    private function validateDirection(string $direction): void
    {
        if (!in_array($direction, self::ALLOWED_DIRECTIONS)) {
            throw new InvalidArgumentException(
                "Invalid sort direction: {$direction}. Allowed directions are: " 
                . implode(', ', self::ALLOWED_DIRECTIONS)
            );
        }
    }

    /**
     * ソート条件の妥当性を検証
     *
     * @throws InvalidArgumentException
     */
    public function validate(): void
    {
        $this->validateColumn($this->column);
        $this->validateDirection($this->direction);
    }

    /**
     * 文字列表現を取得
     */
    public function __toString(): string
    {
        return "{$this->column} {$this->direction}";
    }

    /**
     * デフォルトのソート条件を作成（参加日時の昇順）
     */
    public static function createJoinedAtAsc(): self
    {
        return new self('joined_at', 'asc');
    }

    /**
     * デフォルトのソート条件を作成（参加日時の降順）
     */
    public static function createJoinedAtDesc(): self
    {
        return new self('joined_at', 'desc');
    }

    /**
     * デフォルトのソート条件を作成（ユーザーIDの昇順）
     */
    public static function createUserIdAsc(): self
    {
        return new self('user_id', 'asc');
    }

    /**
     * デフォルトのソート条件を作成（ユーザーIDの降順）
     */
    public static function createUserIdDesc(): self
    {
        return new self('user_id', 'desc');
    }

    /**
     * デフォルトのソート条件を作成（プロジェクトロールIDの昇順）
     */
    public static function createRoleIdAsc(): self
    {
        return new self('role_id', 'asc');
    }

    /**
     * デフォルトのソート条件を作成（プロジェクトロールIDの降順）
     */
    public static function createRoleIdDesc(): self
    {
        return new self('role_id', 'desc');
    }

    /**
     * デフォルトのソート条件を作成（作成日時の昇順）
     */
    public static function createCreatedAtAsc(): self
    {
        return new self('created_at', 'asc');
    }

    /**
     * デフォルトのソート条件を作成（作成日時の降順）
     */
    public static function createCreatedAtDesc(): self
    {
        return new self('created_at', 'desc');
    }

    /**
     * デフォルトのソート条件を作成（更新日時の昇順）
     */
    public static function createUpdatedAtAsc(): self
    {
        return new self('updated_at', 'asc');
    }

    /**
     * デフォルトのソート条件を作成（更新日時の降順）
     */
    public static function createUpdatedAtDesc(): self
    {
        return new self('updated_at', 'desc');
    }
} 