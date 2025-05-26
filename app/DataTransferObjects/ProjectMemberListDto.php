<?php

namespace App\DataTransferObjects;

use Illuminate\Database\Eloquent\Collection;

class ProjectMemberListDto
{
    /**
     * @param Collection $members プロジェクトメンバー一覧
     * @param int $totalCount 総件数
     * @param int $perPage 1ページあたりの件数
     * @param string|null $nextToken 次のページを取得するためのトークン
     */
    public function __construct(
        public readonly Collection $projectMembers,
        public readonly int $totalCount,
        public readonly int $perPage,
        public readonly ?string $nextToken = null
    ) {}

    public static function builder(): ProjectMemberListDtoBuilder
    {
        return new ProjectMemberListDtoBuilder();
    }
}