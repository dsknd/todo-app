<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * マイルストーンとタスクの関連を管理するマイグレーション
 */
return new class extends Migration
{
    /**
     * マイルストーンタスクテーブルを作成
     */
    public function up(): void
    {
        Schema::create('milestone_tasks', function (Blueprint $table) {
            // 関連ID
            $table->unsignedBigInteger('milestone_id');
            $table->unsignedBigInteger('task_id');
            
            // タスクの位置づけ
            $table->unsignedInteger('display_order')->default(0);  // 表示順序
            $table->decimal('weight', 5, 2)->default(1.00);        // タスクの重み（マイルストーンの進捗計算用）
            
            $table->timestamps();

            // 外部キー制約
            $table->foreign('milestone_id')
                ->references('id')
                ->on('project_milestones')
                ->cascadeOnDelete();
            
            $table->foreign('task_id')
                ->references('id')
                ->on('tasks')
                ->cascadeOnDelete();

            // 主キー制約
            $table->primary(['milestone_id', 'task_id']);

            // インデックス
            $table->index('display_order');
        });
    }

    /**
     * ロールバック時の処理
     */
    public function down(): void
    {
        Schema::dropIfExists('milestone_tasks');
    }
};