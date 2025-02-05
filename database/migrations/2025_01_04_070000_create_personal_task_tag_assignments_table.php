<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('personal_task_tag_assignments', function (Blueprint $table) {
            // テーブルコメント
            $table->comment('個人タスクタグ割り当てテーブル');

            // カラム定義
            $table->unsignedBigInteger('personal_task_id')->comment('個人タスクID');
            $table->unsignedBigInteger('personal_tag_id')->comment('個人タグID');

            // 外部キー制約
            $table->foreign('personal_task_id')->references('task_id')->on('personal_tasks')->cascadeOnDelete();
            $table->foreign('personal_tag_id')->references('tag_id')->on('personal_tags')->cascadeOnDelete();

            // 主キー制約
            $table->primary(['personal_tag_id', 'personal_task_id']);

            // インデックス
            $table->index('personal_task_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personal_task_tag_assignments');
    }
}; 