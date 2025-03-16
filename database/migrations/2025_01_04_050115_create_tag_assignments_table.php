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
        Schema::create('tag_assignments', function (Blueprint $table) {
            // カラム定義
            $table->unsignedBigInteger('tag_id')->comment('タグID');
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('task_number');
            $table->unsignedBigInteger('user_id')->comment('割り当て者');
            $table->timestamps();

            // 外部キー設定
            $table->foreign('tag_id')
                ->references('id')
                ->on('tags')
                ->cascadeOnDelete();

            $table->foreign(['project_id', 'task_number'])
                ->references(['project_id', 'task_number'])
                ->on('tasks')
                ->cascadeOnDelete();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();

            // 主キーの設定
            $table->primary(['tag_id', 'project_id', 'task_number']);
        });
    }

    /**
     * タグの割り当てテーブルを削除
     */
    public function down(): void
    {
        Schema::dropIfExists('tag_assignments');
    }
};
