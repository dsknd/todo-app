<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static MANAGEMENT()
 * @method static static OPERATION()
 * @method static static DEVELOPMENT()
 * @method static static RESEARCH()
 * @method static static SALES()
 * @method static static SUPPORT()
 * @method static static ADMINISTRATION()
 * @method static static LEARNING()
 * @method static static LIFE()
 * @method static static HEALTH()
 * @method static static ENTERTAINMENT()
 * @method static static COMMUNICATION()
 * @method static static ASSET()
 * @method static static COMMUNITY()
 * @method static static OTHER()
 */
enum CategoryEnum: int
{
    case UNCATEGORIZED = 1;   // 未分類
    case MANAGEMENT = 2;      // 経営
    case OPERATION = 3;       // 運営
    case DEVELOPMENT = 4;     // 開発
    case RESEARCH = 5;        // 研究
    case SALES = 6;          // 営業
    case SUPPORT = 7;        // 支援
    case ADMINISTRATION = 8;  // 管理
    case LEARNING = 9;       // 学習
    case LIFE = 10;          // 生活
    case HEALTH = 11;        // 健康
    case ENTERTAINMENT = 12;  // 遊び
    case COMMUNICATION = 13;  // 交流
    case ASSET = 14;         // 資産
    case COMMUNITY = 15;     // 地域

    /**
     * カテゴリの表示名を取得
     */
    public static function getDisplayName(self $category): string
    {
        return match ($category) {
            self::UNCATEGORIZED => '未分類',
            self::MANAGEMENT => '経営',
            self::OPERATION => '運営',
            self::DEVELOPMENT => '開発',
            self::RESEARCH => '研究',
            self::SALES => '営業',
            self::SUPPORT => '支援',
            self::ADMINISTRATION => '管理',
            self::LEARNING => '学習',
            self::LIFE => '生活',
            self::HEALTH => '健康',
            self::ENTERTAINMENT => '遊び',
            self::COMMUNICATION => '交流',
            self::ASSET => '資産',
            self::COMMUNITY => '地域',
        };
    }

    /**
     * カテゴリの説明を取得
     */
    public static function getDescription(self $category): string
    {
        return match ($category) {
            self::UNCATEGORIZED => 'まだ分類が決まっていない、または一時的な仮置きの事項',
            self::MANAGEMENT => '会社全体やチームのビジョン、戦略、組織の方向性に関する事項',
            self::OPERATION => 'プロジェクトの進行管理や日々のタスク調整、業務プロセスの改善',
            self::DEVELOPMENT => 'システムやプロダクトの設計・実装、テスト、リリース、さらには保守運用まで、技術面全般',
            self::RESEARCH => '新技術の検証、プロトタイピング、技術調査、製品やサービスの革新を目指す活動全般',
            self::SALES => '顧客対応、販売促進、マーケティング活動、契約交渉など、収益に直結する業務',
            self::SUPPORT => 'ユーザーやクライアントに対するサポート、ヘルプ、コミュニティ運営など',
            self::ADMINISTRATION => 'バックオフィス全般。人事、経理、総務、法務など、社内を回す業務全般',
            self::LEARNING => 'スキルアップや知識習得、自己啓発を目的とした学び全般（※研究とは切り分けて、より自己研鑽や教育の側面にフォーカス）',
            self::LIFE => '日常生活に関するルーティンや雑務、家庭内のタスク全般',
            self::HEALTH => '体調管理、美容、心身のケアに関する活動',
            self::ENTERTAINMENT => '余暇や趣味、リフレッシュに関する活動',
            self::COMMUNICATION => '家族や友人、コミュニティとのつながりやコミュニケーション',
            self::ASSET => '個人や家庭の資金計画、投資、保険など金銭管理関連',
            self::COMMUNITY => '地域社会やコミュニティへの貢献、ボランティア活動など',
        };
    }

    public static function getExamples(self $category): string
    {
        return match ($category) {
            self::UNCATEGORIZED => 'まだ分類が決まっていないアイデア、突発的なタスク、特殊な案件',
            self::MANAGEMENT => '事業計画、経営会議、組織改革、将来ビジョンの策定',
            self::OPERATION => 'プロジェクトスケジュール管理、タスク割り振り、進捗報告、ミーティング運営',
            self::DEVELOPMENT => 'コーディング、システム設計、バグ修正、運用監視',
            self::RESEARCH => '新しいアルゴリズムの検証、技術トレンドのリサーチ、試作モデルの構築、学会発表用の調査',
            self::SALES => '顧客訪問、提案書作成、見積もり、セールスキャンペーンの企画',
            self::SUPPORT => '問い合わせ対応、FAQ整備、オンラインサポート、カスタマーサクセス施策',
            self::ADMINISTRATION => '採用活動、給与計算、経費精算、社内規定の策定、契約書のレビュー',
            self::LEARNING => 'セミナー参加、オンライン講座、資格試験対策、語学学習、業界勉強会',
            self::LIFE => '家事（掃除・料理・洗濯）、買い物、役所手続き、シンプルな家計管理',
            self::HEALTH => '運動（ジム、ランニング）、食事管理、メンタルヘルス、定期健診、通院',
            self::ENTERTAINMENT => '旅行、映画鑑賞、読書、ゲーム、趣味のイベント参加',
            self::COMMUNICATION => '家族の集まり、友人との飲み会、SNSでのやりとり、地域イベント',
            self::ASSET => '家計簿、投資計画、保険の見直し、ローン管理、金融情報のチェック',
            self::COMMUNITY => '地域イベント、NPO支援、ボランティア活動、環境保護プロジェクト',
        };
    }
}