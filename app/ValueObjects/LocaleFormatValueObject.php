<?php

namespace App\ValueObjects;

class LocaleFormatValueObject
{
    private const ALLOWED_FORMATS = [
        'bcp47' => 'bcp47',
        'cldr' => 'cldr',
        'posix' => 'posix',
    ];

    private string $format;

    private function __construct(string $format)
    {
        if (!isset(self::ALLOWED_FORMATS[$format])) {
            throw new \InvalidArgumentException("Invalid locale format: {$format}");
        }

        $this->format = self::ALLOWED_FORMATS[$format];
    }

    public function value(): string
    {
        return $this->format;
    }

    public static function BCP47(): self
    {
        return new self('bcp47');
    }

    public static function CLDR(): self
    {
        return new self('cldr');
    }

    public static function POSIX(): self
    {
        return new self('posix');
    }

    public function equals(LocaleFormatValueObject $other): bool
    {
        return $this->format === $other->value();
    }
}