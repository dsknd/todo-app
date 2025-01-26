<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * プロジェクトとタスクの関連を管理するマイグレーションクラス
 * 
 * 主な機能：
 * - タスクの複数プロジェクト所属
 * - プロジェクト内でのタスクの位置づけ管理
 * - タスクの重み付け（進捗率計算用）
 * - プロジェクト内でのWBS管理
 */
return new class extends Migration
{
    /**
     * プロジェクトタスクテーブルを作成
     */
    public function up(): void
    {
        Schema::create('project_tasks', function (Blueprint $table) {
            // 関連ID
            $table->unsignedBigInteger('task_id');
            $table->unsignedBigInteger('project_id');
            
            // プロジェクト内での位置づけ
            $table->unsignedInteger('display_order')->default(0);     // 表示順序
            $table->string('project_wbs_number')->nullable();         // プロジェクト内でのWBS番号
            $table->decimal('weight', 5, 2)->default(1.00);           // タスクの重み（進捗計算用）
            
            $table->timestamps();                                     // 作成日時、更新日時

            // 外部キー制約
            $table->foreign('task_id')
                ->references('id')
                ->on('tasks')
                ->cascadeOnDelete();
            
            $table->foreign('project_id')
                ->references('id')
                ->on('projects')
                ->cascadeOnDelete();

            // 主キー制約（タスクは複数プロジェクトに所属可能）
            $table->primary(['project_id', 'task_id']);

            // インデックス
            $table->index('display_order');
            $table->index('project_wbs_number');
        });
    }

    /**
     * ロールバック時の処理
     */
    public function down(): void
    {
        Schema::dropIfExists('project_tasks');
    }
};
