<?php

namespace App\ValueObjects;

use InvalidArgumentException;
use App\ValueObjects\ProjectMemberOrderParamList;
use DateTime;

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
     * @param ProjectMemberJoinedAt $joinedAt
     */
    private function __construct(
        private readonly ProjectId $projectId,
        private readonly PaginatorPageCount $pageCount,
        private readonly ProjectMemberOrderParamList $orderParamList,
        private readonly ProjectMemberJoinedAt $joinedAt
    ) {}

    /**
     * プロジェクトID、ページカウント、ソート条件を指定してインスタンスを作成
     * 
     * @param ProjectId $projectId
     * @param PaginatorPageCount $pageCount
     * @param ProjectMemberOrderParamList $orderParamList
     * @param ProjectMemberJoinedAt $joinedAt
     * @return self
     */
    public static function from(
        ProjectId $projectId,
        PaginatorPageCount $pageCount,
        ProjectMemberOrderParamList $orderParamList,
        ProjectMemberJoinedAt $joinedAt,
    ): self {
        return new self(
            $projectId,
            $pageCount,
            $orderParamList,
            $joinedAt
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
        $joinedAt = ProjectMemberJoinedAt::from($data['last_evaluated_key']);

        return new self(
            $projectId,
            $pageCount,
            $orderParamList,
            $joinedAt
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
            'joined_at' => $this->joinedAt->getValue(),
        ];
        
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
     * 参加日時を取得
     * 
     * @return ProjectMemberJoinedAt
     */
    public function getJoinedAt(): ProjectMemberJoinedAt
    {
        return $this->joinedAt;
    }
}