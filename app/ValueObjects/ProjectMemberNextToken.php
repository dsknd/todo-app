<?php

namespace App\ValueObjects;

use InvalidArgumentException;
use App\ValueObjects\ProjectMemberOrderParamList;
use App\ValueObjects\ProjectMemberId;

/**
 * プロジェクトメンバーページネーションの次のトークン
 */
final class ProjectMemberNextToken
{
    /**
     * コンストラクタ
     *
     * @param ProjectId $projectId
     * @param PaginatorPageCount $pageCount
     * @param ProjectMemberOrderParamList $orderParamList
     * @param ProjectMemberId|null $lastId
     */
    private function __construct(
        private readonly ProjectId $projectId,
        private readonly PaginatorPageCount $pageCount,
        private readonly ProjectMemberOrderParamList $orderParamList,
        private readonly ?ProjectMemberId $lastId = null
    ) {}

    /**
     * プロジェクトID、ページカウント、ソート条件を指定してインスタンスを作成
     * 
     * @param ProjectId $projectId
     * @param PaginatorPageCount $pageCount
     * @param ProjectMemberOrderParamList $orderParamList
     * @param ProjectMemberId|null $lastId
     * @return self
     */
    public static function from(
        ProjectId $projectId,
        PaginatorPageCount $pageCount,
        ProjectMemberOrderParamList $orderParamList,
        ?ProjectMemberId $lastId = null,
    ): self {
        return new self(
            $projectId,
            $pageCount,
            $orderParamList,
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
        $pageCount = PaginatorPageCount::from($data['per_page']);
        $orderParamList = ProjectMemberOrderParamList::from($data['order']);
        $lastId = isset($data['last_id']) ? ProjectMemberId::from($data['last_id']) : null;

        return new self(
            $projectId,
            $pageCount,
            $orderParamList,
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
            'per_page' => $this->pageCount->getValue(),
            'order' => $this->orderParamList,
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
     * @return PaginatorPageCount
     */
    public function getPageCount(): PaginatorPageCount
    {
        return $this->pageCount;
    }

    /**
     * ソート条件を取得
     * 
     * @return ProjectMemberOrderParamList
     */
    public function getOrderParamList(): ProjectMemberOrderParamList
    {
        return $this->orderParamList;
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