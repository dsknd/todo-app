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
        Schema::create('custom_task_categories', function (Blueprint $table) {
            // カラム定義
            $table->unsignedBigInteger('category_id'); // カテゴリID
            $table->unsignedBigInteger('type_id'); // タイプID
            $table->unsignedBigInteger('project_id')->nullable(); // プロジェクトID
            $table->unsignedBigInteger('created_by'); // 作成者

            // 外部キー設定
            $table->foreign('category_id')->references('id')->on('task_categories');
            $table->foreign('type_id')->references('id')->on('task_types');
            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('created_by')->references('id')->on('users');

            // 主キー設定
            $table->primary('category_id');

            // インデックス設定
            $table->index('project_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_task_categories');
    }
};
