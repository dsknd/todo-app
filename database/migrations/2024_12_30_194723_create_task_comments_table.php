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
        Schema::create('task_comments', function (Blueprint $table) {
            // カラム
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('task_number');
            $table->unsignedBigInteger('user_id');
            $table->text('content');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->timestamps();

            // 外部キー設定
            $table->foreign(['project_id', 'task_number'])
                ->references(['project_id', 'task_number'])
                ->on('tasks')
                ->cascadeOnDelete();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();

            $table->foreign('parent_id')
                ->references('id')
                ->on('task_comments')
                ->cascadeOnDelete();

            // インデックス設定
            $table->index(['project_id', 'task_number']);
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_comments');
    }
};
