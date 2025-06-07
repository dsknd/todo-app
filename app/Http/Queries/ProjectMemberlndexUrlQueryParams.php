<?php

namespace App\Http\Queries;

use App\ValueObjects\ProjectId;
use App\ValueObjects\PaginationPageSize;
use App\ValueObjects\ProjectMemberSortOrders;
use App\ValueObjects\ProjectMemberSortOrder;
use Illuminate\Http\Request;
use InvalidArgumentException;

class ProjectMemberIndexUrlQueryParams
{
    private function __construct(
        public readonly ProjectId $projectId,
        public readonly PaginationPageSize $pageSize,
        public readonly ProjectMemberSortOrders $sortOrders,
    ) {
    }

    public static function fromRequest(Request $request): self
    {
        $projectId = null;
        $pageSize = null;
        $sortOrders = null;

        // project_idがない場合はエラー
        if ($request->has('project_id')) {
            $projectId = ProjectId::from($request->project_id);
        } else {
            throw new InvalidArgumentException('project_id is required');
        }

        // page_sizeがない場合はデフォルト値
        if ($request->has('page_size')) {
            $pageSize = PaginationPageSize::from($request->page_size);
        } else {
            $pageSize = PaginationPageSize::default();
        }

        // sort_ordersがない場合はデフォルト値
        if ($request->has('sort_orders')) {
            $sortOrders = ProjectMemberSortOrders::from($request->sort_orders);
        } else {
            $sortOrders = ProjectMemberSortOrder::joinedAtDesc();
        }

        return new self($projectId, $pageSize, $sortOrders);
    }

    public function getProjectId(): ProjectId
    {
        return $this->projectId;
    }

    public function getPageSize(): PaginationPageSize
    {
        return $this->pageSize;
    }

    public function getSortOrders(): ProjectMemberSortOrders
    {
        return $this->sortOrders;
    }
}