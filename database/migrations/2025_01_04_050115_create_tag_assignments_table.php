<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * タグの割り当てを管理するテーブルを作成
     * 
     * このテーブルは、タグと各モデル（タスク、プロジェクト、マイルストーンなど）の
     * 関連を管理するためのポリモーフィックな中間テーブルです。
     */
    public function up(): void
    {
        Schema::create('tag_assignments', function (Blueprint $table) {
            // カラム定義
            $table->unsignedBigInteger('tag_id');
            $table->unsignedBigInteger('task_id');
            $table->unsignedBigInteger('assigned_by');
            $table->timestamps();

            // 主キーの設定
            $table->primary(['tag_id', 'task_id']);

            // 外部キー設定
            $table->foreign('tag_id')
                ->references('id')
                ->on('tags')
                ->cascadeOnDelete();

            $table->foreign('assigned_by')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
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
