<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * プロジェクトタスクのタグの割り当てを管理するテーブルを作成
     */
    public function up(): void
    {
        Schema::create('project_task_tag_assignments', function (Blueprint $table) {
            // カラム定義
            $table->unsignedBigInteger('project_task_tag_id');
            $table->unsignedBigInteger('project_task_id');
            $table->unsignedBigInteger('assigned_by');
            $table->timestamps();

            // 主キーの設定
            $table->primary(['project_task_tag_id', 'project_task_id']);

            // 外部キー設定
            $table->foreign('project_task_tag_id')
                ->references('tag_id')
                ->on('project_task_tags')
                ->cascadeOnDelete();

            $table->foreign('project_task_id')
                ->references('task_id')
                ->on('project_tasks')
                ->cascadeOnDelete();

            $table->foreign('assigned_by')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();

            // インデックスの設定
            $table->index('project_task_id');
        });
    }

    /**
     * タグの割り当てテーブルを削除
     */
    public function down(): void
    {
        Schema::dropIfExists('project_task_tag_assignments');
    }
};
