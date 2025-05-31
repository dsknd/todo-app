<?php

namespace App\Repositories\Interfaces;

use App\ValueObjects\ProjectId;
use App\ValueObjects\PaginatorPageCount;
use App\ValueObjects\ProjectMemberOrderParamList;
use App\ReadModels\ProjectMemberReadModel;
use App\ValueObjects\UserId;

interface ProjectMemberQueryRepository
{

    /**
     * プロジェクトメンバーを取得します
     * 
     * @param ProjectId $projectId プロジェクトID
     * @return ProjectMemberReadModel プロジェクトメンバーのコレクション
     */
    public function findByProjectId(ProjectId $projectId): ProjectMemberReadModel;

    /**
     * プロジェクトメンバーを取得します
     * 
     * @param ProjectId $projectId プロジェクトID
     * @param UserId $userId ユーザーID
     * @return ProjectMemberReadModel プロジェクトメンバーのコレクション
     */
    public function findByProjectIdAndUserId(
        ProjectId $projectId,
        UserId $userId
    ): ProjectMemberReadModel;

    /**
     * プロジェクトメンバーを検索します
     * 
     * @param ProjectId $projectId プロジェクトID
     * @param PaginatorPageCount $pageCount ページあたりの表示件数
     * @param ProjectMemberOrderParamList $orderParamList ソート順
     * @return ProjectMemberReadModel プロジェクトメンバーのコレクション
     */
    public function searchProjectMembers(
        ProjectId $projectId,
        PaginatorPageCount $pageCount,
        ProjectMemberOrderParamList $orderParamList
    ): ProjectMemberReadModel;
}