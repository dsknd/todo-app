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
        Schema::create('project_task_statistics', function (Blueprint $table) {
            // カラム定義
            $table->unsignedBigInteger('project_id'); // プロジェクトID
            $table->unsignedBigInteger('status_id');  // ステータスID
            $table->unsignedInteger('count');         // タスク数
            $table->timestamps();                            // 作成日時、更新日時

            // 外部キー
            $table->foreign('project_id')->references('id')->on('projects')->cascadeOnDelete();
            $table->foreign('status_id')->references('id')->on('task_statuses')->cascadeOnDelete();

            // 主キー
            $table->primary(['project_id', 'status_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_task_statistics');
    }
};
