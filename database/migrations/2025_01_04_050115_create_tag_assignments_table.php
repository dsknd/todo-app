<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tag_assignments', function (Blueprint $table) {
            // カラム定義
            $table->unsignedBigInteger('tag_id');          // タグID
            $table->unsignedBigInteger('task_id');  // タスクID

            // 主キーの設定
            $table->primary(['tag_id', 'task_id']);

            // 外部キー設定
            $table->foreign('tag_id')->references('id')->on('tags')->cascadeOnDelete();
            $table->foreign('task_id')->references('id')->on('tasks')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tag_assignments');
    }
};
