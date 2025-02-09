<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\QueryException;

/**
 * タスクテーブルを管理するためのマイグレーションクラス
 *
 * このテーブルは、タスクの情報を管理するためのテーブルです。
 * タスクは、プロジェクトに紐づくタスクと個人に紐づくタスクの2種類があります。
 *
 * 主な機能：
 * - 階層構造管理（親子関係、WBS）
 * - 詳細な時間管理（計画/実績の開始・終了日時）
 * - 工数管理（見積時間、実績時間）
 * - 進捗管理（進捗率）
 * - 優先度管理（重要度と緊急度を分離）
 * - 継続タスク対応
 */
return new class extends Migration
{
    /**
     * タスクテーブルを作成
     * @return void
     * @throws QueryException
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            // 基本情報
            $table->unsignedBigInteger('project_id');   // プロジェクトID
            $table->unsignedBigInteger('task_number');            // タスク番号(プロジェクトごとの採番)

            $table->string('title');                                // タイトル
            $table->text('description')->nullable();                // 詳細
            $table->unsignedBigInteger('user_id');                 // 作成者
            
            // 時間管理
            $table->datetime('planned_start_date')->nullable();     // 予定開始日時
            $table->datetime('planned_end_date')->nullable();      // 予定終了日時
            $table->datetime('actual_start_date')->nullable();     // 実際の開始日時
            $table->datetime('actual_end_date')->nullable();      // 実際の終了日時
            
            // 進捗・優先度
            $table->unsignedBigInteger('priority_id');

            // 分類・所有
            $table->unsignedBigInteger('category_id');             // カテゴリ
            $table->unsignedBigInteger('status_id')->nullable();   // ステータス
            $table->boolean('is_recurring')->default(false);       // 継続タスクかどうか
            
            $table->timestamps();                                  // 作成日時と更新日時
            $table->softDeletes();                                // 論理削除

            // 外部キー制約
            $table->foreign('priority_id')
                ->references('id')
                ->on('priorities')
                ->cascadeOnDelete();

            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->cascadeOnDelete();
            
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
            
            $table->foreign('status_id')
                ->references('id')
                ->on('task_statuses')
                ->cascadeOnDelete();

            $table->foreign('project_id')
                ->references('id')
                ->on('projects')
                ->cascadeOnDelete();

            // 主キー設定
            $table->primary(['project_id', 'task_number']);

            // インデックス
            $table->index(['planned_start_date', 'planned_end_date']);
            $table->index(['actual_start_date', 'actual_end_date']);
            $table->index('priority_id');
            $table->index('status_id');
            $table->index('category_id');
            $table->index('user_id');
        });
    }

    /**
     * タスクテーブルを削除
     * @return void
     * @throws QueryException
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
