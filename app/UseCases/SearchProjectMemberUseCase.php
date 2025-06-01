<?php

namespace App\UseCases;

use App\ValueObjects\ProjectId;
use App\ValueObjects\ProjectMemberSortOrders;
use App\ValueObjects\PaginationPageSize;
use App\DataTransferObjects\ProjectMemberListDto;

/**
 * プロジェクトメンバーを検索するユースケース
 */
interface SearchProjectMemberUseCase
{
    /**
     * プロジェクトメンバー一覧を取得します
     *
     * @param ProjectId $projectId プロジェクトID
     * @param PaginationPageSize|null $pageSize ページあたりの表示件数
     * @param ProjectMemberSortOrders|null $sortOrders ソート順
     * @return ProjectMemberListDto プロジェクトメンバー一覧
     */
    public function execute(
        ProjectId $projectId,
        ?PaginationPageSize $pageSize = null,
        ?ProjectMemberSortOrders $sortOrders = null
    ): ProjectMemberListDto;
} 