<?php

namespace App\DataTransferObjects;

use App\ValueObjects\ProjectId;
use App\ValueObjects\UserId;
use App\ValueObjects\CategoryId;
use App\ValueObjects\PriorityId;
use DateTimeImmutable;
use InvalidArgumentException;

class CreateTaskDTO
{
    /**
     * @param string $title タスクのタイトル
     * @param string|null $description タスクの説明
     * @param ProjectId $projectId プロジェクトID
     * @param UserId $userId 作成者のユーザーID
     * @param CategoryId $categoryId カテゴリ
     * @param PriorityId $priorityId 優先度
     * @param bool $isPrivate 非公開かどうか
     * @param DateTimeImmutable $plannedStartDate 計画開始日
     * @param DateTimeImmutable $plannedEndDate 計画終了日
     * @param DateTimeImmutable|null $actualStartDate 実際の開始日
     * @param DateTimeImmutable|null $actualEndDate 実際の終了日
     */
    public function __construct(
        public readonly string $title,
        public readonly ?string $description,
        public readonly ProjectId $projectId,
        public readonly UserId $userId,
        public readonly CategoryId $categoryId,
        public readonly PriorityId $priorityId,
        public readonly bool $isPrivate,
        public readonly DateTimeImmutable $plannedStartDate,
        public readonly DateTimeImmutable $plannedEndDate,
        public readonly ?DateTimeImmutable $actualStartDate = null,
        public readonly ?DateTimeImmutable $actualEndDate = null
    ) {
        $this->validate();
    }

    /**
     * DTOの検証
     *
     * @throws InvalidArgumentException 検証エラーの場合
     */
    private function validate(): void
    {
        if (empty($this->title)) {
            throw new InvalidArgumentException('タイトルは必須です');
        }

        if ($this->plannedEndDate < $this->plannedStartDate) {
            throw new InvalidArgumentException('計画終了日は計画開始日より後である必要があります');
        }

        if ($this->actualStartDate !== null && $this->actualEndDate !== null && $this->actualEndDate < $this->actualStartDate) {
            throw new InvalidArgumentException('実際の終了日は実際の開始日より後である必要があります');
        }
    }
}