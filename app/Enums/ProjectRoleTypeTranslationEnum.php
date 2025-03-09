<?php

namespace App\Enums;

enum ProjectRoleTypeTranslationEnum: int
{
    case CUSTOM_JA = 'カスタムロール';
    case DEFAULT_JA = 'デフォルトロール';

    case CUSTOM_EN = 'Custom Role';
    case DEFAULT_EN = 'Default Role';

    case CUSTOM_DESCRIPTION_JA = 'プロジェクト固有のカスタムロール';
    case DEFAULT_DESCRIPTION_JA = 'システム定義のデフォルトロール';

    case CUSTOM_DESCRIPTION_EN = 'Project-specific custom role';
    case DEFAULT_DESCRIPTION_EN = 'System-defined default role';

    /**
     * ロールタイプのキーを取得
     */
    public static function getJapaneseName(ProjectRoleTypeEnum $projectRoleType): string
    {
        return match($projectRoleType) {
            ProjectRoleTypeEnum::CUSTOM => 'カスタムロール',
            ProjectRoleTypeEnum::DEFAULT => 'デフォルトロール',
        };
    }

    public static function getEnglishName(ProjectRoleTypeEnum $projectRoleType): string
    {
        return match($projectRoleType) {
            ProjectRoleTypeEnum::CUSTOM => 'Custom Role',
            ProjectRoleTypeEnum::DEFAULT => 'Default Role',
        };
    }

    public static function getJapaneseDescription(ProjectRoleTypeEnum $projectRoleType): string
    {
        return match($projectRoleType) {
            ProjectRoleTypeEnum::CUSTOM => 'プロジェクト固有のカスタムロール',
            ProjectRoleTypeEnum::DEFAULT => 'システム定義のデフォルトロール',
        };
    }

    public static function getEnglishDescription(ProjectRoleTypeEnum $projectRoleType): string
    {
        return match($projectRoleType) {
            ProjectRoleTypeEnum::CUSTOM => 'Project-specific custom role',
            ProjectRoleTypeEnum::DEFAULT => 'System-defined default role',
        };
    }

    public static function getName(ProjectRoleTypeEnum $projectRoleType, LocaleEnum $locale): string
    {
        return match($locale) {
            LocaleEnum::JAPANESE => self::getJapaneseName($projectRoleType),
            LocaleEnum::ENGLISH => self::getEnglishName($projectRoleType),
        };
    }

    public static function getDescription(ProjectRoleTypeEnum $projectRoleType, LocaleEnum $locale): string
    {
        return match($locale) {
            LocaleEnum::JAPANESE => self::getJapaneseDescription($projectRoleType),
            LocaleEnum::ENGLISH => self::getEnglishDescription($projectRoleType),
        };
    }
}
