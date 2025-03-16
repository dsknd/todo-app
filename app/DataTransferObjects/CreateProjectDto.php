<?php

namespace App\DataTransferObjects;

use App\ValueObjects\UserId;
use DateTimeImmutable;
use App\DataTransferObjects\Builders\CreateProjectDtoBuilder;
use App\Http\Requests\CreateProjectRequest;

/**
 * プロジェクト作成DTO
 */
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
     * プロジェクト作成DTOを作成
     * 
     * @param string $name プロジェクト名
     * @param ?string $description プロジェクト説明
     * @param UserId $userId ユーザーID
     * @param bool $isPrivate プライベートフラグ
     * @param ?DateTimeImmutable $plannedStartDate 計画開始日
     * @param ?DateTimeImmutable $plannedEndDate 計画終了日
     * @return self プロジェクト作成DTO
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
     * プロジェクト作成DTOビルダーを取得
     * 
     * @return CreateProjectDtoBuilder プロジェクト作成DTOビルダー
     */
    public static function builder(): CreateProjectDtoBuilder
    {
        return CreateProjectDtoBuilder::builder();
    }

    /**
     * リクエストからプロジェクト作成DTOを構築
     * 
     * @param CreateProjectRequest $request リクエスト
     * @param UserId $userId ユーザーID
     * @return self プロジェクト作成DTO
     */
    public static function fromRequest(CreateProjectRequest $request, UserId $userId): self
    {
        return CreateProjectDtoBuilder::fromRequest($request, $userId);
    }
} 