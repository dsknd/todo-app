<?php

namespace App\Interactors;

use App\Repositories\Interfaces\ProjectMemberRepository;
use App\ValueObjects\ProjectId;
use App\ValueObjects\PaginationPageSize;
use App\ValueObjects\ProjectMemberSortOrder;
use App\ValueObjects\ProjectMemberSortOrders;
use App\ValueObjects\ProjectMemberNextToken;
use App\UseCases\FetchProjectMemberUseCase;
use App\DataTransferObjects\ProjectMemberListDto;

class FetchProjectMemberInteractor implements FetchProjectMemberUseCase
{
    /**
     * コンストラクタ
     *
     * @param ProjectMemberRepository $projectMemberRepository
     */
    public function __construct(
        private readonly ProjectMemberRepository $projectMemberRepository
    ) {
    }

    /**
     * @inheritDoc
     */
    public function execute(
        ProjectId $projectId,
        ?PaginationPageSize $pageSize = null,
        ?ProjectMemberSortOrders $orderParamList = null
    ): ProjectMemberListDto
    {
        $pageSize = PaginationPageSize::from($pageSize->getValue());

        // ソート条件が指定されていない場合は、ソート条件のデフォルト値を設定
        if (!$orderParamList) {
            $orderJoinedAt = ProjectMemberSortOrder::createJoinedAtDesc();
            $orderParamList = ProjectMemberSortOrders::from([$orderJoinedAt]);
        }

        // プロジェクトメンバーを取得
        $projectMembers = $this->projectMemberRepository->searchByProjectId(
            $projectId,
            $pageSize,
            $orderParamList
        );

        // ページ分割が必要な場合は、次のページのトークンを生成
        $hasNextPage = $projectMembers->count() > $pageSize->getValue();
        $lastEvaluatedKey = null;
        if ($hasNextPage) {
            $lastEvaluatedKey = $projectMembers->last()->project_id;
        } else {
            $lastEvaluatedKey = null;
        }

        // プロジェクトメンバー一覧を返す
        return ProjectMemberListDto::builder()
            ->projectMembers($projectMembers)
            ->totalCount($projectMembers->count())
            ->perPage($pageSize->getValue())
            ->nextToken($hasNextPage ? ProjectMemberNextToken::from($projectId, $pageSize, $orderParamList, $lastEvaluatedKey)->encode() : null)
            ->build();
    }
}