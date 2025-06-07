<?php

namespace App\UseCases;

use App\ValueObjects\ProjectId;
use App\ValueObjects\ProjectMemberSortOrders;
use App\ValueObjects\PaginationPageSize;
use Illuminate\Pagination\CursorPaginator;

/**
 * プロジェクトメンバ一覧を取得するユースケース
 *
 * ページネーションを使用して、プロジェクトメンバーを取得します。
 * 
 * ページネーションのページサイズは、デフォルトで10件、最大で100件まで設定できます。
 * @see PaginationPageSize
 * 
 * ソート順は、デフォルトで作成日時の降順です。
 * @see ProjectMemberSortOrders
 * 
 * ページネーションのトークンは、次のページのデータを取得するために使用します。
 * @see ProjectMemberNextToken
 */
interface GetProjectMemberUseCase
{
    /**
     * プロジェクトメンバー一覧を取得します
     *
     * @param ProjectId $projectId プロジェクトID
     * @param PaginationPageSize|null $pageSize ページあたりの表示件数
     * @param ProjectMemberSortOrders|null $sortOrders ソート順
     * @return CursorPaginator
     */
    public function execute(
        ProjectId $projectId,
        ?PaginationPageSize $pageSize = null,
        ?ProjectMemberSortOrders $sortOrders = null
    ): CursorPaginator;
} 