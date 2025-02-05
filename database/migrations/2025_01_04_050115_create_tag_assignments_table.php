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
            $table->unsignedBigInteger('task_id')->comment('タスクID');
            $table->unsignedBigInteger('user_id')->comment('割り当て者');
            $table->timestamps();

            // 主キーの設定
            $table->primary(['tag_id', 'task_id']);

            // 外部キー設定
            $table->foreign('tag_id')
                ->references('id')
                ->on('tags')
                ->cascadeOnDelete();

            $table->foreign('task_id')
                ->references('id')
                ->on('tasks')
                ->cascadeOnDelete();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();

            // インデックスの設定
            $table->index('task_id');
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
