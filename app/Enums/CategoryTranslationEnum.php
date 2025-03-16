<?php

namespace App\Enums;

enum CategoryTranslationEnum: string
{
    case UNCATEGORIZED_JA = '未分類';
    case MANAGEMENT_JA = '経営';
    case OPERATION_JA = '運営';
    case DEVELOPMENT_JA = '開発';
    case RESEARCH_JA = '研究';
    case SALES_JA = '営業';
    case SUPPORT_JA = '支援';
    case ADMINISTRATION_JA = '管理';
    case LEARNING_JA = '学習';
    case LIFE_JA = '生活';
    case HEALTH_JA = '健康';
    case ENTERTAINMENT_JA = '遊び';
    case COMMUNICATION_JA = '交流';
    case ASSET_JA = '資産';
    case COMMUNITY_JA = '地域';
    case OTHER_JA = 'その他';

    case UNCATEGORIZED_DESCRIPTION_JA = 'まだ分類されていません。';
    case MANAGEMENT_DESCRIPTION_JA = '事業計画、経営会議、組織改革、将来ビジョンの策定など、会社全体やチームのビジョン・戦略・方向性に関する事項。';
    case OPERATION_DESCRIPTION_JA = 'プロジェクトスケジュールの管理、タスク割り振り、進捗報告、ミーティング運営など、日々の業務進行やプロセス改善に関する事項。';
    case DEVELOPMENT_DESCRIPTION_JA = 'コーディング、システム設計、バグ修正、運用監視など、プロダクトの設計・実装・テスト・リリース・保守を含む技術面全般。';
    case RESEARCH_DESCRIPTION_JA = '新しいアルゴリズムの検証、技術トレンドの調査、試作モデルの構築、学会発表の準備など、新技術の検証やプロトタイピングを通じて製品やサービスの革新を目指す活動全般。';
    case SALES_DESCRIPTION_JA = '顧客訪問、提案書や見積書の作成、セールスキャンペーンの企画など、顧客対応・販売促進・マーケティング・契約交渉など収益に直結する業務。';
    case SUPPORT_DESCRIPTION_JA = '問い合わせ対応、FAQ整備、オンラインサポート、カスタマーサクセス施策など、ユーザーやクライアントを支援する活動全般。';
    case ADMINISTRATION_DESCRIPTION_JA = '採用活動、給与計算、経費精算、社内規定の策定、契約書のレビューなど、人事・経理・総務・法務などバックオフィス全般の業務。';
    case LEARNING_DESCRIPTION_JA = 'セミナー参加、オンライン講座、資格試験対策、語学学習、業界勉強会など、スキルアップや知識習得、自己啓発を目的とした学び全般。';
    case LIFE_DESCRIPTION_JA = '家事、買い物、役所手続き、家計管理など、日常生活や家庭内のルーティンや雑務に関する活動。';
    case HEALTH_DESCRIPTION_JA = '運動、食事管理、メンタルヘルス、定期健診、通院など、体調管理や美容、心身のケアに関わる活動。';
    case ENTERTAINMENT_DESCRIPTION_JA = '旅行、映画鑑賞、読書、ゲーム、趣味のイベント参加など、余暇や趣味、リフレッシュに関する活動。';
    case COMMUNICATION_DESCRIPTION_JA = '家族や友人との集まり、飲み会、SNSでのやり取り、地域イベントなど、人とのつながりやコミュニケーションに関する活動。';
    case ASSET_DESCRIPTION_JA = '家計簿、投資計画、保険の見直し、ローン管理、金融情報のチェックなど、資金計画や資産管理に関する活動。';
    case COMMUNITY_DESCRIPTION_JA = '地域イベント、NPO支援、ボランティア活動、環境保護プロジェクトなど、地域コミュニティや公益活動、文化・環境への貢献に関わる事項。';
    case OTHER_DESCRIPTION_JA = 'どのカテゴリにも当てはまらないもの。';

    case UNCATEGORIZED_EN = 'Uncategorized';
    case MANAGEMENT_EN = 'Management';
    case OPERATION_EN = 'Operation';
    case DEVELOPMENT_EN = 'Development';
    case RESEARCH_EN = 'Research';
    case SALES_EN = 'Sales';
    case SUPPORT_EN = 'Support';
    case ADMINISTRATION_EN = 'Administration';
    case LEARNING_EN = 'Learning';
    case LIFE_EN = 'Life';
    case HEALTH_EN = 'Health';
    case ENTERTAINMENT_EN = 'Entertainment';
    case COMMUNICATION_EN = 'Communication';
    case ASSET_EN = 'Asset';
    case COMMUNITY_EN = 'Community';
    case OTHER_EN = 'Other';

    case UNCATEGORIZED_DESCRIPTION_EN = 'Not categorized yet.';
    case MANAGEMENT_DESCRIPTION_EN = 'Planning business plans, holding management meetings, organizing organizational reforms, and formulating future visions.';
    case OPERATION_DESCRIPTION_EN = 'Managing project schedules, task assignments, progress reports, and meeting operations.';
    case DEVELOPMENT_DESCRIPTION_EN = 'Coding, system design, bug fixes, monitoring operations, and more, covering all aspects of product design, implementation, testing, release, and maintenance.';
    case RESEARCH_DESCRIPTION_EN = 'Verifying new algorithms, researching technical trends, building prototype models, and preparing for academic presentations.';
    case SALES_DESCRIPTION_EN = 'Customer visits, creating proposal documents and estimates, and planning sales campaigns.';
    case SUPPORT_DESCRIPTION_EN = 'Responding to inquiries, preparing FAQs, providing online support, and implementing customer success strategies.';
    case ADMINISTRATION_DESCRIPTION_EN = 'Recruiting, payroll calculations, expense reimbursements, drafting internal rules, and reviewing contracts.';
    case LEARNING_DESCRIPTION_EN = 'Attending seminars, online courses, preparing for certification exams, language learning, industry studies, and self-improvement activities.';
    case LIFE_DESCRIPTION_EN = 'Housework, shopping, bureaucratic procedures, household management, and other activities related to daily life and family.';
    case HEALTH_DESCRIPTION_EN = 'Exercise, diet management, mental health, regular health checks, and medical visits.';
    case ENTERTAINMENT_DESCRIPTION_EN = 'Travel, movie watching, reading, gaming, and participating in hobby events.';
    case COMMUNICATION_DESCRIPTION_EN = 'Family gatherings, social events, SNS interactions, and regional events.';
    case ASSET_DESCRIPTION_EN = 'Budget management, investment planning, insurance reviews, loan management, and financial information checks.';
    case COMMUNITY_DESCRIPTION_EN = 'Regional events, NPO support, volunteer activities, environmental protection projects, and activities contributing to regional communities, public welfare, and culture and environment.';
    case OTHER_DESCRIPTION_EN = 'Anything that does not fit into the other categories.';

    public static function getJapaneseName(CategoryEnum $category): string
    {
        return match($category) {
            CategoryEnum::UNCATEGORIZED => self::UNCATEGORIZED_JA->value,
            CategoryEnum::MANAGEMENT => self::MANAGEMENT_JA->value,
            CategoryEnum::OPERATION => self::OPERATION_JA->value,
            CategoryEnum::DEVELOPMENT => self::DEVELOPMENT_JA->value,
            CategoryEnum::RESEARCH => self::RESEARCH_JA->value,
            CategoryEnum::SALES => self::SALES_JA->value,
            CategoryEnum::SUPPORT => self::SUPPORT_JA->value,
            CategoryEnum::ADMINISTRATION => self::ADMINISTRATION_JA->value,
            CategoryEnum::LEARNING => self::LEARNING_JA->value,
            CategoryEnum::LIFE => self::LIFE_JA->value,
            CategoryEnum::HEALTH => self::HEALTH_JA->value,
            CategoryEnum::ENTERTAINMENT => self::ENTERTAINMENT_JA->value,
            CategoryEnum::COMMUNICATION => self::COMMUNICATION_JA->value,
            CategoryEnum::ASSET => self::ASSET_JA->value,
            CategoryEnum::COMMUNITY => self::COMMUNITY_JA->value,
            CategoryEnum::OTHER => self::OTHER_JA->value,
        };
    }

    public static function getEnglishName(CategoryEnum $category): string
    {
        return match($category) {
            CategoryEnum::UNCATEGORIZED => self::UNCATEGORIZED_EN->value,
            CategoryEnum::MANAGEMENT => self::MANAGEMENT_EN->value,
            CategoryEnum::OPERATION => self::OPERATION_EN->value,
            CategoryEnum::DEVELOPMENT => self::DEVELOPMENT_EN->value,
            CategoryEnum::RESEARCH => self::RESEARCH_EN->value,
            CategoryEnum::SALES => self::SALES_EN->value,
            CategoryEnum::SUPPORT => self::SUPPORT_EN->value,
            CategoryEnum::ADMINISTRATION => self::ADMINISTRATION_EN->value,
            CategoryEnum::LEARNING => self::LEARNING_EN->value,
            CategoryEnum::LIFE => self::LIFE_EN->value,
            CategoryEnum::HEALTH => self::HEALTH_EN->value,
            CategoryEnum::ENTERTAINMENT => self::ENTERTAINMENT_EN->value,
            CategoryEnum::COMMUNICATION => self::COMMUNICATION_EN->value,
            CategoryEnum::ASSET => self::ASSET_EN->value,
            CategoryEnum::COMMUNITY => self::COMMUNITY_EN->value,
            CategoryEnum::OTHER => self::OTHER_EN->value,
        };
    }

    public static function getJapaneseDescription(CategoryEnum $category): string
    {
        return match($category) {
            CategoryEnum::UNCATEGORIZED => self::UNCATEGORIZED_DESCRIPTION_JA->value,
            CategoryEnum::MANAGEMENT => self::MANAGEMENT_DESCRIPTION_JA->value,
            CategoryEnum::OPERATION => self::OPERATION_DESCRIPTION_JA->value,
            CategoryEnum::DEVELOPMENT => self::DEVELOPMENT_DESCRIPTION_JA->value,
            CategoryEnum::RESEARCH => self::RESEARCH_DESCRIPTION_JA->value,
            CategoryEnum::SALES => self::SALES_DESCRIPTION_JA->value,
            CategoryEnum::SUPPORT => self::SUPPORT_DESCRIPTION_JA->value,
            CategoryEnum::ADMINISTRATION => self::ADMINISTRATION_DESCRIPTION_JA->value,
            CategoryEnum::LEARNING => self::LEARNING_DESCRIPTION_JA->value,
            CategoryEnum::LIFE => self::LIFE_DESCRIPTION_JA->value,
            CategoryEnum::HEALTH => self::HEALTH_DESCRIPTION_JA->value,
            CategoryEnum::ENTERTAINMENT => self::ENTERTAINMENT_DESCRIPTION_JA->value,
            CategoryEnum::COMMUNICATION => self::COMMUNICATION_DESCRIPTION_JA->value,
            CategoryEnum::ASSET => self::ASSET_DESCRIPTION_JA->value,
            CategoryEnum::COMMUNITY => self::COMMUNITY_DESCRIPTION_JA->value,
            CategoryEnum::OTHER => self::OTHER_DESCRIPTION_JA->value,
        };
    }

    public static function getEnglishDescription(CategoryEnum $category): string
    {
        return match($category) {
            CategoryEnum::UNCATEGORIZED => self::UNCATEGORIZED_DESCRIPTION_EN->value,
            CategoryEnum::MANAGEMENT => self::MANAGEMENT_DESCRIPTION_EN->value,
            CategoryEnum::OPERATION => self::OPERATION_DESCRIPTION_EN->value,
            CategoryEnum::DEVELOPMENT => self::DEVELOPMENT_DESCRIPTION_EN->value,
            CategoryEnum::RESEARCH => self::RESEARCH_DESCRIPTION_EN->value,
            CategoryEnum::SALES => self::SALES_DESCRIPTION_EN->value,
            CategoryEnum::SUPPORT => self::SUPPORT_DESCRIPTION_EN->value,
            CategoryEnum::ADMINISTRATION => self::ADMINISTRATION_DESCRIPTION_EN->value,
            CategoryEnum::LEARNING => self::LEARNING_DESCRIPTION_EN->value,
            CategoryEnum::LIFE => self::LIFE_DESCRIPTION_EN->value,
            CategoryEnum::HEALTH => self::HEALTH_DESCRIPTION_EN->value,
            CategoryEnum::ENTERTAINMENT => self::ENTERTAINMENT_DESCRIPTION_EN->value,
            CategoryEnum::COMMUNICATION => self::COMMUNICATION_DESCRIPTION_EN->value,
            CategoryEnum::ASSET => self::ASSET_DESCRIPTION_EN->value,
            CategoryEnum::COMMUNITY => self::COMMUNITY_DESCRIPTION_EN->value,
            CategoryEnum::OTHER => self::OTHER_DESCRIPTION_EN->value,
        };
    }

    public static function getName(CategoryEnum $category, LocaleEnum $locale): string
    {
        return match($locale) {
            LocaleEnum::JAPANESE => self::getJapaneseName($category),
            LocaleEnum::ENGLISH => self::getEnglishName($category),
        };
    }

    public static function getDescription(CategoryEnum $category, LocaleEnum $locale): string
    {
        return match($locale) {
            LocaleEnum::JAPANESE => self::getJapaneseDescription($category),
            LocaleEnum::ENGLISH => self::getEnglishDescription($category),
        };
    }
} 
    