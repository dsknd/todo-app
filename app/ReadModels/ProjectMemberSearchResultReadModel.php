<?php

namespace App\ReadModels;

use Illuminate\Support\Collection;
use App\ValueObjects\ProjectMemberNextToken;
use JsonSerializable;

/**
 * プロジェクトメンバー検索結果のReadModel
 * 
 * @property Collection<ProjectMemberReadModel> $members プロジェクトメンバーのコレクション
 * @property ?ProjectMemberNextToken $nextToken 次のページのトークン
 * @property bool $hasMore 次のページがあるかどうか
 */
class ProjectMemberSearchResultReadModel implements JsonSerializable
{
    public function __construct(
        public readonly Collection $members,
        public readonly ?ProjectMemberNextToken $nextToken,
        public readonly bool $hasMore
    ) {}

    /**
     * 検索結果が空かどうか
     * 
     * @return bool 検索結果が空かどうか
     */
    public function isEmpty(): bool
    {
        return $this->members->isEmpty();
    }

    /**
     * 検索結果の件数
     * 
     * @return int 検索結果の件数
     */
    public function count(): int
    {
        return $this->members->count();
    }

    /**
     * プロジェクトメンバーのコレクションを取得
     * 
     * @return Collection<ProjectMemberReadModel> プロジェクトメンバーのコレクション
     */
    public function members(): Collection
    {
        return $this->members;
    }

    /**
     * 次のページのトークンを取得
     * 
     * @return ?ProjectMemberNextToken 次のページのトークン
     */
    public function nextToken(): ?ProjectMemberNextToken
    {
        return $this->nextToken;
    }

    /**
     * 次のページがあるかどうか
     */
    public function hasNextPage(): bool
    {
        return $this->hasMore;
    }

    /**
     * JSONシリアライゼーション
     * 
     * @return array 配列
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * メンバーリストを配列として取得
     * 
     * @return array 配列
     */
    public function toArray(): array
    {
        return [
            'members' => $this->members->toArray(),
            'pagination' => [
                'current_count' => $this->count(),
                'has_more' => $this->hasMore,
                'next_token' => $this->nextToken?->encode(),
            ],
        ];
    }
} 