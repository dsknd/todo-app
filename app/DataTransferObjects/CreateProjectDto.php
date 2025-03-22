<?php

namespace App\DataTransferObjects;

use App\ValueObjects\UserId;
use DateTimeImmutable;
use App\DataTransferObjects\Builders\CreateProjectDtoBuilder;
use App\Http\Requests\CreateProjectRequest;
use App\ValueObjects\ProjectStatusId;
use App\Enums\ProjectStatusEnum;
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
        public readonly ProjectStatusId $projectStatusId,
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
        ProjectStatusId $projectStatusId,
        ?DateTimeImmutable $plannedStartDate = null,
        ?DateTimeImmutable $plannedEndDate = null,
    ): self {
        return new self(
            name: $name,
            description: $description,
            userId: $userId,
            isPrivate: $isPrivate,
            projectStatusId: $projectStatusId,
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
     * @return self プロジェクト作成DTO
     */
    public static function fromRequest(CreateProjectRequest $request): self
    {
        return CreateProjectDtoBuilder::fromRequest($request);
    }

    /**
     * プロジェクト作成DTOを配列に変換
     * 
     * @return array プロジェクト作成DTOの配列
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'user_id' => $this->userId,
            'is_private' => $this->isPrivate,
            'project_status_id' => $this->projectStatusId,
            'planned_start_date' => $this->plannedStartDate,
            'planned_end_date' => $this->plannedEndDate,
        ];
    }
} 