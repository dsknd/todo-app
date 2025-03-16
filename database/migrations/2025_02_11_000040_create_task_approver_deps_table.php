<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('task_approver_deps', function (Blueprint $table) {
            // カラム定義
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('task_number');
            $table->unsignedBigInteger('ascendant_user_id'); // 先行承認者
            $table->unsignedBigInteger('descendant_user_id'); // 後続承認者
            $table->timestamps();

            // 外部キー定義
            $table->foreign(['project_id', 'task_number'])
                    ->references(['project_id', 'task_number'])
                    ->on('tasks')
                    ->cascadeOnDelete();

            $table->foreign(['project_id', 'task_number', 'ascendant_user_id'], 'fk_task_approver_deps_asc')
                    ->references(['project_id', 'task_number', 'user_id'])
                    ->on('task_approvers')
                    ->cascadeOnDelete();

            $table->foreign(['project_id', 'task_number', 'descendant_user_id'], 'fk_task_approver_deps_desc')
                    ->references(['project_id', 'task_number', 'user_id'])
                    ->on('task_approvers')
                    ->cascadeOnDelete();

            // 主キー定義
            $table->primary(['project_id', 'task_number', 'ascendant_user_id', 'descendant_user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('task_approver_deps');
    }
}; 