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
        Schema::create('project_task_assignments', function (Blueprint $table) {
            $table->foreignId('task_id')->constrained('project_tasks', 'task_id')->cascadeOnDelete();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('assigned_by');
        
            // 外部キー: 割り当てられたユーザー
            $table->foreign(['project_id', 'user_id'])
                  ->references(['project_id', 'user_id'])
                  ->on('project_members')
                  ->cascadeOnDelete();
        
            // 外部キー: 割り当てを行ったユーザー
            $table->foreign(['project_id', 'assigned_by'])
                  ->references(['project_id', 'user_id'])
                  ->on('project_members')
                  ->cascadeOnDelete();
        
            $table->primary(['task_id', 'user_id']);
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_task_assignments');
    }
};
