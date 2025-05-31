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

    public function projectMemberId(): ProjectMemberId
    {
        return $this->projectMemberId;
    }

    public function projectId(): ProjectId
    {
        return $this->projectId;
    }

    public function user(): User
    {
        return $this->user;
    }

    public function userId(): UserId
    {
        return $this->user->id;
    }

    public function userName(): string
    {
        return $this->user->name;
    }

    public function userEmail(): string
    {
        return $this->user->email;
    }

    public function joinedAt(): DateTime
    {
        return $this->joinedAt;
    }
}