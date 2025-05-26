<?php

namespace App\UseCases;

use App\ValueObjects\ProjectId;
use App\ValueObjects\ProjectMemberOrderParamList;
use App\ValueObjects\PaginatorPageCount;
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
     * @param PaginatorPageCount|null $pageCount ページあたりの表示件数
     * @param ProjectMemberOrderParamList|null $orderParamList ソート順
     * @return ProjectMemberListDto プロジェクトメンバー一覧
     */
    public function execute(
        ProjectId $projectId,
        ?PaginatorPageCount $pageCount = null,
        ?ProjectMemberOrderParamList $orderParamList = null
    ): ProjectMemberListDto;
} 