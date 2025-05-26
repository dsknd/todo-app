<?php

namespace App\Interactors;

use App\Repositories\Interfaces\ProjectMemberRepository;
use App\ValueObjects\ProjectId;
use App\ValueObjects\PaginatorPageCount;
use App\ValueObjects\ProjectMemberOrderParam;
use App\ValueObjects\ProjectMemberOrderParamList;
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
        ?PaginatorPageCount $pageCount = null,
        ?ProjectMemberOrderParamList $orderParamList = null
    ): ProjectMemberListDto
    {
        $pageCount = PaginatorPageCount::from($pageCount->getValue());

        // ソート条件が指定されていない場合は、ソート条件のデフォルト値を設定
        if (!$orderParamList) {
            $orderJoinedAt = ProjectMemberOrderParam::createJoinedAtDesc();
            $orderParamList = ProjectMemberOrderParamList::from([$orderJoinedAt]);
        }

        // プロジェクトメンバーを取得
        $projectMembers = $this->projectMemberRepository->searchByProjectId(
            $projectId,
            $pageCount,
            $orderParamList
        );

        // ページ分割が必要な場合は、次のページのトークンを生成
        $hasNextPage = $projectMembers->count() > $pageCount->getValue();
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
            ->perPage($pageCount->getValue())
            ->nextToken($hasNextPage ? ProjectMemberNextToken::from($projectId, $pageCount, $orderParamList, $lastEvaluatedKey)->encode() : null)
            ->build();
    }
}