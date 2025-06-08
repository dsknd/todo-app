<?php

namespace App\Interactors;

use App\Repositories\Interfaces\ProjectMemberQueryRepository;
use App\ValueObjects\ProjectId;
use App\ValueObjects\PaginationPageSize;
use App\ValueObjects\ProjectMemberSortOrder;
use App\ValueObjects\ProjectMemberSortOrders;
use App\UseCases\GetProjectMemberUseCase;
use Illuminate\Pagination\CursorPaginator;

class GetProjectMemberInteractor implements GetProjectMemberUseCase
{
    /**
     * コンストラクタ
     *
     * @param ProjectMemberQueryRepository $projectMemberQueryRepository
     */
    public function __construct(
        private readonly ProjectMemberQueryRepository $projectMemberQueryRepository
    ) {
    }

    /**
     * @inheritDoc
     */
    public function execute(
        ProjectId $projectId,
        ?PaginationPageSize $pageSize = null,
        ?ProjectMemberSortOrders $orderParamList = null
    ): CursorPaginator
    {
        // ページサイズが指定されていない場合は、デフォルト値を設定
        if ($pageSize === null) {
            $pageSize = PaginationPageSize::default();
        }

        // ソート条件が指定されていない場合は、ソート条件のデフォルト値を設定
        if (!$orderParamList) {
            $orderJoinedAt = ProjectMemberSortOrder::joinedAtDesc();
            $orderParamList = ProjectMemberSortOrders::from([$orderJoinedAt]);
        }

        // プロジェクトメンバーを取得
        $projectMembers = $this->projectMemberQueryRepository->getByProjectId(
            $projectId,
            $pageSize,
            $orderParamList
        );

        return $projectMembers;
    }
}