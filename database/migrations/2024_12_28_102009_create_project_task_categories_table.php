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
        Schema::create('project_task_categories', function (Blueprint $table) {
            // カラム
            $table->unsignedBigInteger('category_id'); // タスクカテゴリID
            $table->unsignedBigInteger('project_id')->nullable(); // プロジェクトID
            $table->unsignedBigInteger('user_id')->nullable(); // プロジェクトカテゴリ作成者

            // $table->foreignId('category_id')->constrained('task_categories')->cascadeOnDelete();
            // $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();

            // 外部キー設定
            $table->foreign('project_id')
                ->references('id')
                ->on('projects')
                ->cascadeOnDelete();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();

            $table->foreign('category_id')
                ->references('id')
                ->on('task_categories')
                ->cascadeOnDelete();

            // 主キー設定
            $table->primary('category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_task_categories');
    }
};
