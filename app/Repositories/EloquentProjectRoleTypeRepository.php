<?php

namespace App\Repositories;

use App\Repositories\Interfaces\ProjectRoleTypeQueryRepository;
use App\ReadModels\ProjectRoleTypeReadModel;
use App\ValueObjects\ProjectRoleTypeId;
use App\ValueObjects\LocaleCode;
use Illuminate\Support\Collection;
use App\Models\ProjectRoleType;
use Illuminate\Database\Eloquent\Builder;

class EloquentProjectRoleTypeRepository implements ProjectRoleTypeQueryRepository
{

    /**
     * SELECTで取得するフィールド
     * プロジェクトロールタイプのID、名前、説明を取得
     */
    const SELECT_FIELDS = [
        'project_role_types.id as id',
        'project_role_type_translations.name as name',
        'project_role_type_translations.description as description',
    ];

    /**
     * プロジェクトロールタイプテーブルと翻訳テーブルのJOIN条件
     * 多言語対応のため翻訳テーブルと結合
     */
    const JOIN_FIELDS_PROJECT_ROLE_TYPE_TRANSLATIONS = [
        'project_role_type_translations',
        'project_role_types.id',
        '=',
        'project_role_type_translations.project_role_type_id',
    ];

    /**
     * 翻訳テーブルとロケールテーブルのJOIN条件
     * 指定された言語の翻訳データを取得するため
     */
    const JOIN_FIELDS_LOCALES = [
        'locales',
        'project_role_type_translations.locale_id',
        '=',
        'locales.id',
    ];

    /**
     * 指定された言語でプロジェクトロールタイプを取得するためのベースクエリを構築
     *
     * @param LocaleCode $localeCode 取得したい言語（例: 'ja', 'en'）
     * @return Builder 設定済みのクエリビルダー
     */
    private function getCommonQuery(LocaleCode $localeCode): Builder
    {
        $query = ProjectRoleType::query();

        // 翻訳テーブルと結合（多言語対応）
        $query = $query->join(...self::JOIN_FIELDS_PROJECT_ROLE_TYPE_TRANSLATIONS);

        // ロケールテーブルと結合（言語指定のため）
        $query = $query->join(...self::JOIN_FIELDS_LOCALES);

        // 指定された言語でフィルタリング（例: 'ja'なら日本語のデータのみ）
        $query->where('locales.language_code', $localeCode->getLanguage());

        // 必要なフィールドのみを取得
        $query->select(self::SELECT_FIELDS);

        return $query;
    }

    /**
     * @inheritDoc
     */
    public function find(ProjectRoleTypeId $projectRoleTypeId, LocaleCode $localeCode): ProjectRoleTypeReadModel
    {
        $query = $this->getCommonQuery($localeCode);

        // 特定のプロジェクトロールタイプIDでフィルタリング
        $query->where('project_role_types.id', $projectRoleTypeId->getValue());

        $result = $query->firstOrFail();
        
        return new ProjectRoleTypeReadModel(
            $result->id,
            $result->name,
            $result->description,
        );
    }

    /**
     * @inheritDoc
     */
    public function get(LocaleCode $localeCode): Collection
    {
        $query = $this->getCommonQuery($localeCode);

        // 全てのプロジェクトロールタイプを取得してReadModelに変換
        return new Collection(
            $query->get()->map(function ($projectRoleType) {
                return new ProjectRoleTypeReadModel(
                    $projectRoleType->id,
                    $projectRoleType->name,
                    $projectRoleType->description,
                );
            }),
        );
    }
}