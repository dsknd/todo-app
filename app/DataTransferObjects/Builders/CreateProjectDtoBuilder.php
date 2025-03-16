<?php

namespace App\DataTransferObjects\Builders;

use App\DataTransferObjects\CreateProjectDto;
use App\ValueObjects\UserId;
use DateTimeImmutable;
use App\Http\Requests\CreateProjectRequest;

class CreateProjectDtoBuilder
{
    private string $name;
    private ?string $description = null;
    private UserId $userId;
    private bool $isPrivate = false;
    private ?DateTimeImmutable $plannedStartDate = null;
    private ?DateTimeImmutable $plannedEndDate = null;

    protected function __construct()
    {
    }

    public static function builder(): self
    {
        return new self();
    }

    /**
     * リクエストからDTOを構築
     * @internal このメソッドは CreateProjectDto::fromRequest() を通じて呼び出されることを意図しています
     */
    public static function fromRequest(CreateProjectRequest $request, UserId $userId): CreateProjectDto
    {
        $validated = $request->validated();

        return self::builder()
            ->name($validated['name'])
            ->description($validated['description'] ?? null)
            ->userId($userId)
            ->isPrivate($validated['is_private'])
            ->plannedStartDate(
                isset($validated['planned_start_date']) 
                    ? new DateTimeImmutable($validated['planned_start_date'])
                    : null
            )
            ->plannedEndDate(
                isset($validated['planned_end_date'])
                    ? new DateTimeImmutable($validated['planned_end_date'])
                    : null
            )
            ->build();
    }

    public function name(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function description(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function userId(UserId $userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    public function isPrivate(bool $isPrivate): self
    {
        $this->isPrivate = $isPrivate;
        return $this;
    }

    public function plannedStartDate(?DateTimeImmutable $plannedStartDate): self
    {
        $this->plannedStartDate = $plannedStartDate;
        return $this;
    }

    public function plannedEndDate(?DateTimeImmutable $plannedEndDate): self
    {
        $this->plannedEndDate = $plannedEndDate;
        return $this;
    }

    /**
     * DTOを構築
     * 
     * @throws \InvalidArgumentException 必須パラメータが設定されていない場合
     */
    public function build(): CreateProjectDto
    {
        if (!isset($this->name)) {
            throw new \InvalidArgumentException('プロジェクト名は必須です');
        }

        if (!isset($this->userId)) {
            throw new \InvalidArgumentException('ユーザーIDは必須です');
        }

        return new CreateProjectDto(
            name: $this->name,
            description: $this->description,
            userId: $this->userId,
            isPrivate: $this->isPrivate,
            plannedStartDate: $this->plannedStartDate,
            plannedEndDate: $this->plannedEndDate,
        );
    }
} 