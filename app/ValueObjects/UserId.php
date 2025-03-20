<?php

namespace App\ValueObjects;

use InvalidArgumentException;
use JsonSerializable;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
final class UserId implements JsonSerializable
{
    private int $id;

    /**
     * @param int $id
     * @throws InvalidArgumentException IDが無効な場合
     */
    public function __construct(int $id)
    {
        if ($id <= 0) {
            throw new InvalidArgumentException('ユーザーIDは正の整数である必要があります');
        }

        $this->id = $id;
    }

    /**
     * 値を取得
     *
     * @return int
     */
    public function getValue(): int
    {
        return $this->id;
    }

    /**
     * 等価性の比較
     *
     * @param UserId $other
     * @return bool
     */
    public function equals(self $other): bool
    {
        return $this->id === $other->id;
    }

    /**
     * 文字列表現
     *
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->id;
    }

    /**
     * JSONシリアライズ時に呼ばれるメソッド
     *
     * @return mixed
     */
    public function jsonSerialize(): mixed
    {
        return $this->id;
    }

    /**
     * 文字列からUserIdを作成
     *
     * @param string $id
     * @return self
     */
    public static function fromString(string $id): self
    {
        if (!ctype_digit($id)) {
            throw new InvalidArgumentException('ユーザーIDは数値である必要があります');
        }
        
        return new self((int) $id);
    }

    /**
     * 現在認証されているユーザーからUserIdを作成
     *
     * @return self
     * @throws \RuntimeException 認証されていない場合
     */
    public static function fromAuth(): self
    {
        $user = Auth::user();
        if (!$user) {
            throw new UnauthorizedHttpException('Bearer', 'Unauthorized');
        }
        
        return new self($user->id->getValue());
    }

    /**
     * リクエストの認証済みユーザーからUserIdを作成
     *
     * @return self
     * @throws \RuntimeException 認証されていない場合
     */
    public static function fromRequest(): self
    {
        $user = request()->user();
        
        if ($user === null) {
            throw new \RuntimeException('認証されていません');
        }
        
        return new self((int) $user->id);
    }

    /**
     * リクエストヘッダーからUserIdを作成
     *
     * @return self
     * @throws \RuntimeException ヘッダーが存在しない場合
     */
    public static function fromRequestHeader(): self
    {
        $id = request()->header('X-User-Id');
        
        if ($id === null) {
            throw new \RuntimeException('X-User-Idヘッダーが存在しません');
        }
        
        return self::fromString($id);
    }
}