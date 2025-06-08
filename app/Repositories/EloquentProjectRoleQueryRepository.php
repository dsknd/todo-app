<?php

namespace App\Repositories;

use App\Repositories\Interfaces\ProjectRoleQueryRepository;
use App\ValueObjects\ProjectRoleId;
use App\ReadModels\ProjectRoleReadModel;
use App\ValueObjects\ProjectId;
use App\Models\ProjectRole;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use App\ValueObjects\LocaleCode;
use App\ValueObjects\ProjectRoleType;
use App\ValueObjects\ProjectRoleTypeId;
use App\Enums\ProjectRoleTypeEnum;

class EloquentProjectRoleQueryRepository implements ProjectRoleQueryRepository
{
    const SELECT_FIELDS = [
        'project_roles.id as id',                                                             // プロジェクトロールID
        'project_roles.project_role_type_id as project_role_type_id',                         // プロジェクトロールタイプID
        'project_role_type_translations.name as project_role_type_name',                      // プロジェクトロールタイプ名
        'project_role_type_translations.description as project_role_type_description',        // プロジェクトロールタイプ説明
        'default_project_role_translations.name as default_project_role_name',                // デフォルトプロジェクトロール名
        'default_project_role_translations.description as default_project_role_description',  // デフォルトプロジェクトロール説明
        'custom_project_roles.name as custom_project_role_name',                              // カスタムプロジェクトロール名
        'custom_project_roles.description as custom_project_role_description',                // カスタムプロジェクトロール説明
        'project_roles.assignable_limit as assignable_limit',                                 // 割り当て可能なメンバー数
        'project_roles.assigned_count as assigned_count',                                     // 割り当てられたメンバー数

    ];

    /**
     * プロジェクトロールタイプテーブルとのJOIN条件
     */
    const JOIN_FIELDS_PROJECT_ROLE_TYPE = [
        'project_role_types',
        'project_roles.project_role_type_id',
        '=',
        'project_role_types.id',
    ];

    /**
     * プロジェクトロールタイプ翻訳テーブルとのJOIN条件
     */
    const JOIN_FIELDS_PROJECT_ROLE_TYPE_TRANSLATIONS = [
        'project_role_type_translations',
        'project_role_types.id',
        '=',
        'project_role_type_translations.project_role_type_id',
    ];

    /**
     * プロジェクトロールタイプ翻訳テーブルとロケールテーブルのJOIN条件
     */
    const JOIN_FIELDS_PROJECT_ROLE_TYPE_TRANSLATIONS_LOCALES = [
        'locales',
        'project_role_type_translations.locale_id',
        '=',
        'locales.id',
    ];

    /**
     * デフォルトプロジェクトロールテーブルとのJOIN条件
     */
    const JOIN_FIELDS_DEFAULT_PROJECT_ROLES = [
        'default_project_roles',
        'project_roles.id',
        '=',
        'default_project_roles.project_role_id',
    ];

    /**
     * カスタムプロジェクトロールテーブルとのJOIN条件
     */
    const JOIN_FIELDS_CUSTOM_PROJECT_ROLES = [
        'custom_project_roles',
        'project_roles.id',
        '=',
        'custom_project_roles.project_role_id',
    ];

    /**
     * デフォルトプロジェクトロール翻訳テーブルとのJOIN条件
     */
    const JOIN_FIELDS_DEFAULT_PROJECT_ROLE_TRANSLATIONS = [
        'default_project_role_translations',
        'default_project_roles.project_role_id',
        '=',
        'default_project_role_translations.default_project_role_id',
    ];

    private function getCommonQuery(LocaleCode $localeCode): Builder
    {
        return ProjectRole::select(self::SELECT_FIELDS)
            // プロジェクトロールタイプテーブルとのJOIN
            ->join(...self::JOIN_FIELDS_PROJECT_ROLE_TYPE)

            // プロジェクトロールタイプ翻訳テーブルとのJOIN
            ->join(...self::JOIN_FIELDS_PROJECT_ROLE_TYPE_TRANSLATIONS)

            // プロジェクトロールタイプ翻訳テーブルとロケールテーブルのJOIN
            ->join(...self::JOIN_FIELDS_PROJECT_ROLE_TYPE_TRANSLATIONS_LOCALES)

            // デフォルトプロジェクトロールテーブルとのJOIN
            ->leftJoin(...self::JOIN_FIELDS_DEFAULT_PROJECT_ROLES)

            // デフォルトプロジェクトロール翻訳テーブルとのJOIN（ロケールも考慮）
            ->leftJoin('default_project_role_translations', function($join) {
                $join->on('default_project_roles.project_role_id', '=', 'default_project_role_translations.default_project_role_id')
                     ->on('default_project_role_translations.locale_id', '=', 'locales.id');
            })

            // カスタムプロジェクトロールテーブルとのJOIN
            ->leftJoin(...self::JOIN_FIELDS_CUSTOM_PROJECT_ROLES)

            // ロケールコードの指定
            ->where('locales.language_code', $localeCode->getLanguage());
    }

    /**
     * クエリ結果からマッピング
     */
    private function mapQueryResult(ProjectRole $result): ProjectRoleReadModel
    {
        $projectRoleType = new ProjectRoleType(
            new ProjectRoleTypeId($result->project_role_type_id->getValue()),
            $result->project_role_type_name,
            $result->project_role_type_description,
        );

        $name = null;
        $description = null;

        // project_role_type_idはキャストされているのでgetValue()を使って比較
        if($result->project_role_type_id->getValue() === ProjectRoleTypeEnum::DEFAULT->value) {
            $name = $result->default_project_role_name;
            $description = $result->default_project_role_description ?? $projectRoleType->description;
        }

        if($result->project_role_type_id->getValue() === ProjectRoleTypeEnum::CUSTOM->value) {
            $name = $result->custom_project_role_name;
            $description = $result->custom_project_role_description;
        }

        return new ProjectRoleReadModel(
            $result->id instanceof ProjectRoleId ? $result->id : new ProjectRoleId($result->id),
            $projectRoleType,
            $name ?? '',
            $description ?? '',
            $result->assignable_limit ?? 0,
            $result->assigned_count ?? 0,
        );
    }

    /**
     * @inheritDoc
     */
    public function find(ProjectRoleId $projectRoleId, LocaleCode $localeCode): ProjectRoleReadModel
    {
        $query = $this->getCommonQuery($localeCode);
        $query->where('project_roles.id', $projectRoleId->getValue());
        $result = $query->firstOrFail();

        $projectRoleReadModel = $this->mapQueryResult($result);

        return $projectRoleReadModel;
    }

    /**
     * @inheritDoc
     */
    public function getByProjectId(ProjectId $projectId, LocaleCode $localeCode): Collection
    {
        $query = $this->getCommonQuery($localeCode);
        $query->where('custom_project_roles.project_id', $projectId->getValue());
        $resultCollection = $query->get();

        $projectRoles = [];

        foreach ($resultCollection as $result) {
            $projectRoles[] = $this->mapQueryResult($result);
        }

        return new Collection($projectRoles);
    }
}