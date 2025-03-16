<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('task_histories', function (Blueprint $table) {
            // カラム定義
            $table->id();
            $table->unsignedBigInteger('task_history_type_id');
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('task_number');
            $table->unsignedBigInteger('user_id')->comment('アクションをしたユーザーID');
            $table->timestamps();

            // 外部キー制約
            $table->foreign(['project_id', 'task_number'])
                ->references(['project_id', 'task_number'])
                ->on('tasks')
                ->cascadeOnDelete();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();

            $table->foreign('task_history_type_id')
                ->references('id')
                ->on('task_history_types')
                ->cascadeOnDelete();

            // インデックス
            $table->index('task_history_type_id');
            $table->index(['project_id', 'task_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('task_histories');
    }
}; 