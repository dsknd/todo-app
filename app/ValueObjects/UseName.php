<?php

namespace App\ValueObjects;

use JsonSerializable;
use InvalidArgumentException;

final class UserName implements JsonSerializable
{
    // 英数字、アンダースコア、ハイフンのみ
    const VALID_CHARACTERS_REGEX = '/^[a-zA-Z0-9_-]+$/';
    const MAX_LENGTH = 20;
    const MIN_LENGTH = 3;

    private function __construct(
        private readonly string $name
    ) {}

    public static function from(string $name): self
    {
        $name = self::normalize($name);
        self::validate($name);
        return new self($name);
    }

    private static function normalize(string $name): string
    {
        // 前後の空白を除去し、小文字に統一
        return strtolower(trim($name));
    }

    private static function validate(string $name): void
    {
        // 空文字チェック
        if (empty($name)) {
            throw new InvalidArgumentException('Username cannot be empty');
        }

        // 文字数チェック（ASCII文字のみなのでstrlen()でOK）
        $length = strlen($name);
        if ($length < self::MIN_LENGTH) {
            throw new InvalidArgumentException("Username must be at least " . self::MIN_LENGTH . " characters");
        }

        if ($length > self::MAX_LENGTH) {
            throw new InvalidArgumentException("Username must be at most " . self::MAX_LENGTH . " characters");
        }

        // 使用可能文字チェック
        if (!preg_match(self::VALID_CHARACTERS_REGEX, $name)) {
            throw new InvalidArgumentException('Username can only contain letters, numbers, underscores, and hyphens');
        }

        // 最初の文字は英字である必要（数字開始を禁止）
        if (is_numeric($name[0])) {
            throw new InvalidArgumentException('Username cannot start with a number');
        }

        // 連続するアンダースコア/ハイフンを禁止
        if (preg_match('/[_-]{2,}/', $name)) {
            throw new InvalidArgumentException('Username cannot contain consecutive underscores or hyphens');
        }

        // 最初と最後がアンダースコア/ハイフンを禁止
        if (preg_match('/^[_-]|[_-]$/', $name)) {
            throw new InvalidArgumentException('Username cannot start or end with underscore or hyphen');
        }
    }

    public function getValue(): string
    {
        return $this->name;
    }

    public function jsonSerialize(): string
    {
        return $this->name;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}