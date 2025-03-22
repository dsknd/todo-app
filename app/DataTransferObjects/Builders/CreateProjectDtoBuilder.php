<?php

namespace App\DataTransferObjects\Builders;

use App\DataTransferObjects\CreateProjectDto;
use App\ValueObjects\UserId;
use DateTimeImmutable;
use App\Http\Requests\CreateProjectRequest;
use App\ValueObjects\ProjectStatusId;
use App\Enums\ProjectStatusEnum;
/**
 * プロジェクト作成DTOビルダー
 */
class CreateProjectDtoBuilder
{
    private string $name;
    private ?string $description = null;
    private UserId $userId;
    private bool $isPrivate = false;
    private ProjectStatusId $projectStatusId;
    private ?DateTimeImmutable $plannedStartDate = null;
    private ?DateTimeImmutable $plannedEndDate = null;

    protected function __construct()
    {
    }

    /**
     * プロジェクト作成DTOビルダーを取得
     * 
     * @return self プロジェクト作成DTOビルダー
     */
    public static function builder(): self
    {
        return new self();
    }

    /**
     * リクエストからプロジェクト作成DTOを構築
     * 
     * @param CreateProjectRequest $request リクエスト
     * @return CreateProjectDto プロジェクト作成DTO
     * @internal このメソッドは CreateProjectDto::fromRequest() を通じて呼び出されることを意図しています
     */
    public static function fromRequest(CreateProjectRequest $request): CreateProjectDto
    {
        $validated = $request->validated();
        $userId = UserId::fromAuth();

        return self::builder()
            ->name($validated['name'])
            ->description($validated['description'] ?? null)
            ->userId($userId)
            ->isPrivate($validated['is_private'])
            ->projectStatusId(ProjectStatusId::fromEnum(ProjectStatusEnum::PLANNING))
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

    /**
     * プロジェクト名を設定
     * 
     * @param string $name プロジェクト名
     * @return self プロジェクト作成DTOビルダー
     */
    public function name(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * プロジェクト説明を設定
     * 
     * @param ?string $description プロジェクト説明
     * @return self プロジェクト作成DTOビルダー
     */
    public function description(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * ユーザーIDを設定
     * 
     * @param UserId $userId ユーザーID
     * @return self プロジェクト作成DTOビルダー
     */
    public function userId(UserId $userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * プライベートフラグを設定
     * 
     * @param bool $isPrivate プライベートフラグ
     * @return self プロジェクト作成DTOビルダー
     */
    public function isPrivate(bool $isPrivate): self
    {
        $this->isPrivate = $isPrivate;
        return $this;
    }

    /**
     * プロジェクトステータスIDを設定
     * 
     * @param ProjectStatusId $projectStatusId プロジェクトステータスID
     * @return self プロジェクト作成DTOビルダー
     */
    public function projectStatusId(ProjectStatusId $projectStatusId): self
    {
        $this->projectStatusId = $projectStatusId;
        return $this;
    }

    /**
     * 計画開始日を設定
     * 
     * @param ?DateTimeImmutable $plannedStartDate 計画開始日
     * @return self プロジェクト作成DTOビルダー
     */
    public function plannedStartDate(?DateTimeImmutable $plannedStartDate): self
    {
        $this->plannedStartDate = $plannedStartDate;
        return $this;
    }

    /**
     * 計画終了日を設定
     * 
     * @param ?DateTimeImmutable $plannedEndDate 計画終了日
     * @return self プロジェクト作成DTOビルダー
     */
    public function plannedEndDate(?DateTimeImmutable $plannedEndDate): self
    {
        $this->plannedEndDate = $plannedEndDate;
        return $this;
    }

    /**
     * プロジェクト作成DTOを構築
     * 
     * @throws \InvalidArgumentException 必須パラメータが設定されていない場合
     * @return CreateProjectDto プロジェクト作成DTO
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
            projectStatusId: $this->projectStatusId,
            plannedStartDate: $this->plannedStartDate,
            plannedEndDate: $this->plannedEndDate,
        );
    }
} 