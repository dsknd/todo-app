<?php

namespace App\ValueObjects;

use InvalidArgumentException;

/**
 * プロジェクトメンバーページネーションの次のトークン
 */
final class ProjectMemberNextToken
{
    /**
     * コンストラクタ
     *
     * @param ProjectId $projectId
     * @param PaginationPageSize $pageSize
     * @param ProjectMemberSortOrders $sortOrders
     * @param ProjectMemberId|null $lastId
     */
    private function __construct(
        private readonly ProjectId $projectId,
        private readonly PaginationPageSize $pageSize,
        private readonly ProjectMemberSortOrders $sortOrders,
        private readonly ?ProjectMemberId $lastId = null
    ) {}

    /**
     * プロジェクトID、ページカウント、ソート条件を指定してインスタンスを作成
     * 
     * @param ProjectId $projectId
     * @param PaginationPageSize $pageSize
     * @param ProjectMemberSortOrders $sortOrders
     * @param ProjectMemberId|null $lastId
     * @return self
     */
    public static function from(
        ProjectId $projectId,
        PaginationPageSize $pageSize,
        ProjectMemberSortOrders $sortOrders,
        ?ProjectMemberId $lastId = null,
    ): self {
        return new self(
            $projectId,
            $pageSize,
            $sortOrders,
            $lastId
        );
    }

    /**
     * トークンからインスタンスを作成
     * 
     * @param string $token
     * @return self
     */
    public static function fromToken(string $token): self
    {
        $data = json_decode(base64_decode($token), true);

        if (!$data) {
            throw new InvalidArgumentException('Invalid token format');
        }

        $projectId = ProjectId::from($data['project_id']);
        $pageCount = PaginationPageSize::from($data['per_page']);
        $sortOrders = ProjectMemberSortOrders::from($data['order']);
        $lastId = isset($data['last_id']) ? ProjectMemberId::from($data['last_id']) : null;

        return new self(
            $projectId,
            $pageCount,
            $sortOrders,
            $lastId
        );
    }

    /**
     * トークンにエンコード
     * 
     * @return string
     */
    public function encode(): string
    {
        $data = [
            'project_id' => $this->projectId->getValue(),
            'per_page' => $this->pageSize->getValue(),
            'order' => $this->sortOrders,
        ];
        
        if ($this->lastId) {
            $data['last_id'] = $this->lastId->getValue();
        }
        
        return base64_encode(json_encode($data));
    }

    /**
     * プロジェクトIDを取得
     * 
     * @return ProjectId
     */
    public function getProjectId(): ProjectId
    {
        return $this->projectId;
    }

    /**
     * ページカウントを取得
     * 
     * @return PaginationPageSize
     */
    public function getPageSize(): PaginationPageSize
    {
        return $this->pageSize;
    }

    /**
     * ソート条件を取得
     * 
     * @return ProjectMemberSortOrders
     */
    public function getSortOrders(): ProjectMemberSortOrders
    {
        return $this->sortOrders;
    }

    /**
     * 最後のIDを取得
     * 
     * @return ProjectMemberId|null
     */
    public function getLastId(): ?ProjectMemberId
    {
        return $this->lastId;
    }
}