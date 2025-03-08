<?php

namespace App\DataTransferObjects\Builders;

use App\DataTransferObjects\CreateTaskDTO;
use App\ValueObjects\ProjectId;
use App\ValueObjects\UserId;
use App\ValueObjects\CategoryId;
use App\ValueObjects\PriorityId;
use DateTimeImmutable;

class CreateTaskDTOBuilder
{
    private string $title = '';
    private ?string $description = null;
    private ?ProjectId $projectId = null;
    private ?UserId $userId = null;
    private ?CategoryId $categoryId = null;
    private ?PriorityId $priorityId = null;
    private bool $isPrivate = false;
    private ?DateTimeImmutable $plannedStartDate = null;
    private ?DateTimeImmutable $plannedEndDate = null;
    private ?DateTimeImmutable $actualStartDate = null;
    private ?DateTimeImmutable $actualEndDate = null;

    public function withTitle(string $title): self
    {
        $clone = clone $this;
        $clone->title = $title;
        return $clone;
    }

    public function withDescription(?string $description): self
    {
        $clone = clone $this;
        $clone->description = $description;
        return $clone;
    }

    public function withProjectId(ProjectId $projectId): self
    {
        $clone = clone $this;
        $clone->projectId = $projectId;
        return $clone;
    }

    public function withUserId(UserId $userId): self
    {
        $clone = clone $this;
        $clone->userId = $userId;
        return $clone;
    }

    public function withCategoryId(CategoryId $categoryId): self
    {
        $clone = clone $this;
        $clone->categoryId = $categoryId;
        return $clone;
    }

    public function withPriorityId(PriorityId $priorityId): self
    {
        $clone = clone $this;
        $clone->priorityId = $priorityId;
        return $clone;
    }

    public function withIsPrivate(bool $isPrivate): self
    {
        $clone = clone $this;
        $clone->isPrivate = $isPrivate;
        return $clone;
    }

    public function withPlannedStartDate(DateTimeImmutable $plannedStartDate): self
    {
        $clone = clone $this;
        $clone->plannedStartDate = $plannedStartDate;
        return $clone;
    }

    public function withPlannedEndDate(DateTimeImmutable $plannedEndDate): self
    {
        $clone = clone $this;
        $clone->plannedEndDate = $plannedEndDate;
        return $clone;
    }

    public function withActualStartDate(?DateTimeImmutable $actualStartDate): self
    {
        $clone = clone $this;
        $clone->actualStartDate = $actualStartDate;
        return $clone;
    }

    public function withActualEndDate(?DateTimeImmutable $actualEndDate): self
    {
        $clone = clone $this;
        $clone->actualEndDate = $actualEndDate;
        return $clone;
    }
    
    public function build(): CreateTaskDTO
    {
        // 必須パラメータのチェック
        if ($this->projectId === null) {
            throw new \InvalidArgumentException('プロジェクトIDは必須です');
        }

        if ($this->userId === null) {
            throw new \InvalidArgumentException('ユーザーIDは必須です');
        }

        if ($this->categoryId === null) {
            throw new \InvalidArgumentException('カテゴリIDは必須です');
        }

        if ($this->priorityId === null) {
            throw new \InvalidArgumentException('優先度IDは必須です');
        }

        if ($this->plannedStartDate === null) {
            throw new \InvalidArgumentException('計画開始日は必須です');
        }

        if ($this->plannedEndDate === null) {
            throw new \InvalidArgumentException('計画終了日は必須です');
        }

        return new CreateTaskDTO(
            $this->title,
            $this->description,
            $this->projectId,
            $this->userId,
            $this->categoryId,
            $this->priorityId,
            $this->isPrivate,
            $this->plannedStartDate,
            $this->plannedEndDate,
            $this->actualStartDate,
            $this->actualEndDate
        );
    }

    // リクエストからDTOを構築するファクトリーメソッド
    public static function fromRequest(\Illuminate\Http\Request $request): self
    {
        $builder = new self();
        
        return $builder
            ->withTitle($request->input('title'))
            ->withDescription($request->input('description'))
            ->withProjectId(new ProjectId($request->input('project_id')))
            ->withUserId(new UserId($request->user()->id))
            ->withCategoryId(new CategoryId($request->input('category_id')))
            ->withPriorityId(new PriorityId($request->input('priority_id')))
            ->withIsPrivate($request->boolean('is_private', false))
            ->withPlannedStartDate(new DateTimeImmutable($request->input('planned_start_date')))
            ->withPlannedEndDate(new DateTimeImmutable($request->input('planned_end_date')))
            ->withActualStartDate($request->input('actual_start_date') ? new DateTimeImmutable($request->input('actual_start_date')) : null)
            ->withActualEndDate($request->input('actual_end_date') ? new DateTimeImmutable($request->input('actual_end_date')) : null);
    }
}