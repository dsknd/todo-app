<?php

namespace App\UseCases;

use App\ValueObjects\ProjectId;
use App\ValueObjects\ProjectMemberSortOrders;
use App\ValueObjects\PaginationPageSize;
use App\DataTransferObjects\ProjectMemberListDto;

/**
 * プロジェクトメンバー一覧を取得するユースケース
 */
interface FetchProjectMemberUseCase
{
    /**
     * プロジェクトメンバー一覧を取得します
     *
     * @param ProjectId $projectId プロジェクトID
     * @param PaginationPageSize|null $pageCount ページあたりの表示件数
     * @param ProjectMemberSortOrders|null $orderParamList ソート順
     * @return ProjectMemberListDto プロジェクトメンバー一覧
     */
    public function execute(
        ProjectId $projectId,
        ?PaginationPageSize $pageCount = null,
        ?ProjectMemberSortOrders $orderParamList = null
    ): ProjectMemberListDto;
} 