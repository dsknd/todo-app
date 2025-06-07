<?php

namespace App\ReadModels;

use JsonSerializable;
use App\ValueObjects\ProjectId;
use App\Models\User;
use App\ValueObjects\ProjectMemberId;
use App\ValueObjects\UserId;
use DateTime;

/**
 * プロジェクトメンバーのReadModel（読み取り専用DTO）
 * 
 * @property ProjectMemberId $projectMemberId プロジェクトメンバーID
 * @property ProjectId $projectId プロジェクトID
 * @property User $user ユーザー
 * @property DateTime $joinedAt 参加日時
 */
class ProjectMemberReadModel implements JsonSerializable
{
    public function __construct(
        public readonly ProjectMemberId $projectMemberId,
        public readonly ProjectId $projectId,
        public readonly User $user,
        public readonly DateTime $joinedAt,
        // TODO: プロジェクトロールを追加
    ) {}

    public function toArray(): array
    {
        return [
            'project_member_id' => $this->projectMemberId->getValue(),
            'project_id' => $this->projectId->getValue(),
            'user' => $this->user->toArray(),
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function getProjectMemberId(): ProjectMemberId
    {
        return $this->projectMemberId;
    }

    public function getProjectId(): ProjectId
    {
        return $this->projectId;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getUserId(): UserId
    {
        return $this->user->id;
    }

    public function getUserName(): string
    {
        return $this->user->name;
    }

    public function getUserEmail(): string
    {
        return $this->user->email;
    }

    public function getJoinedAt(): DateTime
    {
        return $this->joinedAt;
    }

    /**
     * マジックゲッターでsnake_caseのプロパティアクセスをサポート
     * CursorPaginatorがソート用のカラム値にアクセスするために必要
     */
    public function __get($name)
    {
        switch ($name) {
            case 'project_member_id':
                return $this->projectMemberId;
            case 'project_id':
                return $this->projectId;
            case 'user_id':
                return $this->user->id;
            case 'joined_at':
            case 'project_members.joined_at':  // テーブル名付きのアクセスもサポート
                return $this->joinedAt;
            case 'project_members.id':  // テーブル名付きのIDアクセスもサポート
                return $this->projectMemberId->getValue();
            default:
                throw new \Exception("Property {$name} does not exist");
        }
    }
}