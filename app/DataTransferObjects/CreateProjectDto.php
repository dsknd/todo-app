<?php

namespace App\DataTransferObjects;

use App\ValueObjects\UserId;
use DateTimeImmutable;
use App\DataTransferObjects\Builders\CreateProjectDtoBuilder;
use App\Http\Requests\CreateProjectRequest;

class CreateProjectDto
{
    public function __construct(
        public readonly string $name,
        public readonly ?string $description,
        public readonly UserId $userId,
        public readonly bool $isPrivate,
        public readonly ?DateTimeImmutable $plannedStartDate,
        public readonly ?DateTimeImmutable $plannedEndDate,
    ) {}

    /**
     * DTOを作成
     */
    public static function create(
        string $name,
        ?string $description,
        UserId $userId,
        bool $isPrivate = false,
        ?DateTimeImmutable $plannedStartDate = null,
        ?DateTimeImmutable $plannedEndDate = null,
    ): self {
        return new self(
            name: $name,
            description: $description,
            userId: $userId,
            isPrivate: $isPrivate,
            plannedStartDate: $plannedStartDate,
            plannedEndDate: $plannedEndDate,
        );
    }

    /**
     * ビルダーを取得
     */
    public static function builder(): CreateProjectDtoBuilder
    {
        return CreateProjectDtoBuilder::builder();
    }

    /**
     * リクエストからDTOを構築
     */
    public static function fromRequest(CreateProjectRequest $request, UserId $userId): self
    {
        return CreateProjectDtoBuilder::fromRequest($request, $userId);
    }
} 