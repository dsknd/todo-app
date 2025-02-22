<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('task_approvals', function (Blueprint $table) {
            // カラム定義
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('task_number');
            $table->unsignedBigInteger('approver_user_id');
            $table->unsignedBigInteger('request_user_id');
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('approval_number');
            $table->text('comment')->nullable();
            $table->timestamp('requested_at')->nullable();
            $table->timestamp('responded_at')->nullable();
            $table->timestamps();

            // 外部キー定義
            $table->foreign(['project_id', 'task_number'])
                    ->references(['project_id', 'task_number'])
                    ->on('tasks')
                    ->cascadeOnDelete();

            $table->foreign(['project_id', 'task_number', 'approver_user_id'])
                    ->references(['project_id', 'task_number', 'user_id'])
                    ->on('task_approvers')
                    ->cascadeOnDelete();

            $table->foreign(['project_id', 'request_user_id'])
                    ->references(['project_id', 'user_id'])
                    ->on('project_members')
                    ->cascadeOnDelete();

            $table->foreign('status_id')
                    ->references('id')
                    ->on('task_approval_statuses')
                    ->cascadeOnDelete();

            // 主キー定義
            $table->primary(['project_id', 'task_number', 'approval_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('task_approvals');
    }
}; 