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
     */
    public function isEmpty(): bool
    {
        return $this->members->isEmpty();
    }

    /**
     * 検索結果の件数
     */
    public function count(): int
    {
        return $this->members->count();
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
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * メンバーリストを配列として取得
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