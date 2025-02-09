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
            
            // 階層構造
            $table->unsignedBigInteger('parent_project_id')->nullable();  // 親プロジェクト
            
            // 時間管理
            $table->datetime('planned_start_date')->nullable();        // 予定開始日時
            $table->datetime('planned_end_date')->nullable();         // 予定終了日時
            $table->datetime('actual_start_date')->nullable();        // 実際の開始日時
            $table->datetime('actual_end_date')->nullable();         // 実際の終了日時
            
            // 進捗管理
            $table->unsignedBigInteger('project_status_id');         // プロジェクトステータス
            $table->decimal('progress', 5, 2)->default(0);           // 進捗率（0-100%）
            $table->unsignedInteger('member_count')->default(0);     // メンバー数
            $table->unsignedInteger('task_count')->default(0);       // タスク数
            
            // 分類・作成者
            $table->boolean('is_personal')->default(false);         // 個人プロジェクトかどうか
            $table->unsignedBigInteger('created_by');                // 作成者
            
            $table->timestamps();                                    // 作成日時、更新日時
            $table->softDeletes();                                  // 論理削除

            // 外部キー制約
            $table->foreign('parent_project_id')
                ->references('id')
                ->on('projects')
                ->nullOnDelete();
            
            $table->foreign('project_status_id')
                ->references('id')
                ->on('project_statuses')
                ->cascadeOnDelete();
            
            $table->foreign('created_by')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
            
            // インデックス
            $table->index('parent_project_id');
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
