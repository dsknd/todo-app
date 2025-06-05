<?php

namespace App\ValueObjects;

use JsonSerializable;
use InvalidArgumentException;

final class UserNameKeyword implements JsonSerializable
{
    const MIN_KEYWORD_LENGTH = 3;
    const MAX_KEYWORD_LENGTH = 50;
    
    private function __construct(
        private readonly string $keyword
    ) {}

    public function getValue(): string
    {
        return $this->keyword;
    }

    public function __toString(): string
    {
        return $this->keyword;
    }

    public static function from(string $keyword): self
    {
        self::validate($keyword);
        return new self($keyword);
    }

    public function jsonSerialize(): string
    {
        return $this->keyword;
    }

    private function validate(string $keyword): void
    {
        // キーワードの長さを検証
        if (strlen($keyword) < self::MIN_KEYWORD_LENGTH) {
            throw new InvalidArgumentException('Keyword must be at least 3 characters');
        }

        // 印刷可能文字のみ許可
        if (!preg_match('/^[\x20-\x7E]+$/', $keyword)) {
            throw new InvalidArgumentException('Keyword must contain only printable ASCII characters');
        }
    }
}