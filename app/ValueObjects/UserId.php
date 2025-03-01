<?php

namespace App\ValueObjects;

use Illuminate\Support\Facades\Auth;

final class UserId
{
    private int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function equals(UserId $other): bool
    {
        return $this->id === $other->id;
    }

    public function __toString(): string
    {
        return (string) $this->id;
    }

    public static function fromString(string $id): self
    {
        return new self((int) $id);
    }

    public static function fromAuth(): self
    {
        return new self(Auth::id());
    }

    public static function fromRequest(): self
    {
        return new self(request()->user()->id);
    }

    public static function fromRequestHeader(): self
    {
        return new self(request()->header('X-User-Id'));
    }
}
