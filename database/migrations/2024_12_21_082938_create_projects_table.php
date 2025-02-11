<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


/**
 * プロジェクトを管理するためのマイグレーションクラス
 */
return new class extends Migration
{
    /**
     * プロジェクトテーブルを作成します。
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            // 基本情報
            $table->id();
            $table->string('name');                                    // プロジェクト名
            $table->text('description')->nullable();                   // プロジェクトの説明
            
            // 時間管理
            $table->datetime('planned_start_date')->nullable();        // 予定開始日時
            $table->datetime('planned_end_date')->nullable();         // 予定終了日時
            $table->datetime('actual_start_date')->nullable();        // 実際の開始日時
            $table->datetime('actual_end_date')->nullable();         // 実際の終了日時
            
            // 進捗管理
            $table->unsignedBigInteger('project_status_id');         // プロジェクトステータス
            
            // 分類・作成者
            $table->boolean('is_private');         // 個人のプロジェクトでプロジェクトメンバの追加などを行わないプロジェクト
            $table->unsignedBigInteger('user_id');                // 作成者
            
            $table->timestamps();                                    // 作成日時、更新日時

            // 外部キー制約
            $table->foreign('project_status_id')
                ->references('id')
                ->on('project_statuses')
                ->cascadeOnDelete();
            
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
            
            // インデックス
            $table->index(['planned_start_date', 'planned_end_date']);
        });
    }

    /**
     * プロジェクトテーブルを削除します。
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
