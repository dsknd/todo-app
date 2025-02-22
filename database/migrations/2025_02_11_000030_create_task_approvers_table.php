<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('task_approvers', function (Blueprint $table) {
            // カラム定義
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('task_number');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            // 外部キー定義
            $table->foreign(['project_id', 'task_number'])
                    ->references(['project_id', 'task_number'])
                    ->on('tasks')
                    ->cascadeOnDelete();

            $table->foreign(['project_id', 'user_id'])
                    ->references(['project_id', 'user_id'])
                    ->on('project_members')
                    ->cascadeOnDelete();

            // 主キー定義
            $table->primary(['project_id', 'task_number', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('task_approvers');
    }
}; 