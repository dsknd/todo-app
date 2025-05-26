<?php

namespace App\ValueObjects;

use InvalidArgumentException;
use JsonSerializable;

/**
 * 1ページあたりの表示件数の値オブジェクト
 */
final class PaginatorPageCount implements JsonSerializable
{

    /**
     * ページ数の最小値
     */
    private const MIN_PAGE_COUNT = 1;

    /**
     * ページ数の最大値
     */
    private const MAX_PAGE_COUNT = 100;

    /**
     * ページ数のデフォルト値
     */
    private const DEFAULT_PAGE_COUNT = 15;

    /**
     * @param int $pageCount ページ数
     * @throws InvalidArgumentException
     */
    private function __construct(
        private readonly int $pageCount
    ) {
        $this->validatePageCount($pageCount);
    }

    /**
     * 文字列からインスタンスを作成
     *
     * @param int $pageCount ページ数
     * @throws InvalidArgumentException
     */
    public static function from(int $pageCount): self
    {
        return new self($pageCount);
    }

    /**
     * デフォルト値でインスタンスを作成
     */
    public static function default(): self
    {
        return new self(self::DEFAULT_PAGE_COUNT);
    }

    /**
     * 別のインスタンスと等価か判定
     */
    public function equals(self $other): bool
    {
        return $this->pageCount === $other->pageCount;
    }

    /**
     * ページ数の妥当性を検証
     *
     * @throws InvalidArgumentException
     */
    private function validatePageCount(int $pageCount): void
    {
        if ($pageCount < self::MIN_PAGE_COUNT) {
            throw new InvalidArgumentException('Page count must be greater than or equal to ' . self::MIN_PAGE_COUNT);
        }
        if ($pageCount > self::MAX_PAGE_COUNT) {
            throw new InvalidArgumentException('Page count must be less than or equal to ' . self::MAX_PAGE_COUNT);
        }
    }

    /**
     * 文字列表現を取得
     */
    public function __toString(): string
    {
        return "{$this->pageCount}";
    }

    /**
     * ページ数を取得
     *
     * @return int
     */
    public function getValue(): int
    {
        return $this->pageCount;
    }

    /**
     * JSONシリアライズ
     *
     * @return int
     */
    public function jsonSerialize(): mixed
    {
        return $this->pageCount;
    }
} 