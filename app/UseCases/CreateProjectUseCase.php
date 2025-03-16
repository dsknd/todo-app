<?php

namespace App\UseCases;

use App\ValueObjects\UserId;
use DateTimeImmutable;
use App\Models\Project;
use App\ValueObjects\LocaleCode;

interface CreateProjectUseCase
{
    /**
     * 新しいプロジェクトを作成する
     *
     * @param string $name プロジェクト名
     * @param string $description プロジェクトの説明
     * @param UserId $userId プロジェクトオーナーのユーザーID
     * @param bool $isPrivate プロジェクトの公開/非公開
     * @param DateTimeImmutable $plannedStartDate 計画開始日
     * @param DateTimeImmutable $plannedEndDate 計画終了日
     * @return Project 作成されたプロジェクト
     */
    public function execute(
        string $name,
        ?string $description,
        UserId $userId,
        bool $isPrivate,
        ?DateTimeImmutable $plannedStartDate,
        ?DateTimeImmutable $plannedEndDate,
    ): Project;
}