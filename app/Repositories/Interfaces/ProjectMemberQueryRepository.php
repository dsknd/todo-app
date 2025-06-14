<?php

namespace App\Repositories\Interfaces;

use App\ValueObjects\ProjectId;
use App\ValueObjects\PaginationPageSize;
use App\ValueObjects\ProjectMemberSortOrders;
use App\ReadModels\ProjectMemberReadModel;
use App\ValueObjects\UserId;
use App\ValueObjects\ProjectMemberId;
use App\ValueObjects\ProjectMemberNextToken;
use App\ReadModels\ProjectMemberSearchResultReadModel;
use Illuminate\Pagination\CursorPaginator;

interface ProjectMemberQueryRepository
{
    /**
     * プロジェクトメンバーを取得します
     * 
     * @param ProjectMemberId $projectMemberId プロジェクトメンバーID
     * @return ProjectMemberReadModel プロジェクトメンバー
     */
    public function find(
        ProjectMemberId $projectMemberId
    ): ?ProjectMemberReadModel;

    /**
     * プロジェクトIDとユーザIDでプロジェクトメンバーを取得します
     * 
     * @param ProjectId $projectId プロジェクトID
     * @param UserId $userId ユーザID
     * @return ProjectMemberReadModel プロジェクトメンバー
     */
    public function findByProjectIdAndUserId(
        ProjectId $projectId,
        UserId $userId)
    : ?ProjectMemberReadModel;

    /**
     * プロジェクトIDでプロジェクトメンバーを取得します
     * 
     * @param ProjectId $projectId プロジェクトID
     * @return CursorPaginator<ProjectMemberReadModel> プロジェクトメンバーのカーソルページネーター
     */
    public function getByProjectId(
        ProjectId $projectId,
        PaginationPageSize $pageSize,
        ProjectMemberSortOrders $sortOrders,
    ): CursorPaginator;

    /**
     * プロジェクトメンバーを検索します
     * 
     * @param ProjectId $projectId プロジェクトID
     * @param PaginationPageSize $pageSize ページあたりの表示件数
     * @param ProjectMemberSortOrders $sortOrders ソート順
     * @return ProjectMemberSearchResultReadModel プロジェクトメンバーのコレクション
     */
    public function search(
        ProjectId $projectId,
        PaginationPageSize $pageSize,
        ProjectMemberSortOrders $sortOrders
    ): ProjectMemberSearchResultReadModel;

    /**
     * NextTokenを使ってプロジェクトメンバーを検索します
     * 
     * @param ProjectMemberNextToken $nextToken NextToken
     * @return ProjectMemberSearchResultReadModel プロジェクトメンバーのコレクション
     */
    public function searchByNextToken(
        ProjectMemberNextToken $nextToken
    ): ProjectMemberSearchResultReadModel;
}