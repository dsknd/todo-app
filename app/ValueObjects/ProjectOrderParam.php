<?php

namespace App\ValueObjects;

use InvalidArgumentException;

final class ProjectOrderParam
{
    /**
     * ソート可能なカラム一覧
     */
    private const ALLOWED_COLUMNS = [
        'created_at',
        'name',
        'planned_start_date',
        'planned_end_date',
        'actual_start_date',
        'actual_end_date',
    ];

    /**
     * ソート方向の一覧
     */
    private const ALLOWED_DIRECTIONS = ['asc', 'desc'];

    /**
     * @param string $column ソート対象のカラム
     * @param string $direction ソート方向
     * @throws InvalidArgumentException
     */
    private function __construct(
        private readonly string $column,
        private readonly string $direction
    ) {
        $this->validateColumn($column);
        $this->validateDirection($direction);
    }

    /**
     * デフォルトのソート条件を作成（作成日時の降順）
     */
    public static function createDefault(): self
    {
        return new self('created_at', 'desc');
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
     * 文字列表現を取得
     */
    public function __toString(): string
    {
        return "{$this->column} {$this->direction}";
    }
} 