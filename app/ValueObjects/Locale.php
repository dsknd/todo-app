<?php

namespace App\ValueObjects;

class Locale
{
    private const ALLOWED_LANGUAGES = ['ja', 'en'];
    private const ALLOWED_REGIONS = ['JP', 'US', 'GB', 'AU'];
    private const ALLOWED_SCRIPTS = ['Latn', 'Jpan'];

    private const ALLOWED_LANGUAGE_REGION_PAIRS = [
        'ja' => ['JP'], // 日本語は日本のみ
        'en' => ['US', 'GB', 'AU'], // 英語はUS, GB, AU
    ];

    private string $language;
    private ?string $region;
    private ?string $script;

    public function __construct(string $locale)
    {
        $parts = explode('-', $locale);
        $this->language = strtolower($parts[0]);
        $this->script = count($parts) > 1 && in_array($parts[1], self::ALLOWED_SCRIPTS, true) ? $parts[1] : null;
        $this->region = count($parts) > 2 ? strtoupper($parts[2]) : (count($parts) > 1 && !$this->script ? strtoupper($parts[1]) : null);

        if (!in_array($this->language, self::ALLOWED_LANGUAGES, true)) {
            throw new \InvalidArgumentException("Invalid language code: {$this->language}");
        }

        if ($this->region !== null && !in_array($this->region, self::ALLOWED_REGIONS, true)) {
            throw new \InvalidArgumentException("Invalid region code: {$this->region}");
        }

        if ($this->region !== null && !isset(self::ALLOWED_LANGUAGE_REGION_PAIRS[$this->language])) {
            throw new \InvalidArgumentException("Unsupported language-region pair: {$this->language}-{$this->region}");
        }

        if ($this->region !== null && !in_array($this->region, self::ALLOWED_LANGUAGE_REGION_PAIRS[$this->language], true)) {
            throw new \InvalidArgumentException("Invalid language-region pair: {$this->language}-{$this->region}");
        }
    }

    public function format(LocaleFormat $format): string
    {
        return match ($format->value()) {
            'bcp47' => $this->script
                ? "{$this->language}-{$this->script}-{$this->region}"
                : ($this->region ? "{$this->language}-{$this->region}" : $this->language),
            'cldr' => $this->region ? "{$this->language}_{$this->region}" : $this->language,
            'posix' => $this->region ? "{$this->language}_{$this->region}.UTF-8" : "{$this->language}.UTF-8",
            default => throw new \InvalidArgumentException("Unsupported format"),
        };
    }
}