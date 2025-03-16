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
        Schema::create('recurring_task_activities', function (Blueprint $table) {
            // カラム定義
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('task_number');

            $table->timestamp('scheduled_at'); // 実行日時
            $table->unsignedBigInteger('recurring_task_status_id');
            $table->timestamps();

            // 外部キー制約
            $table->foreign(['project_id', 'task_number'])
                ->references(['project_id', 'task_number'])
                ->on('recurring_tasks')
                ->cascadeOnDelete();

            $table->foreign('recurring_task_status_id')
                ->references('id')
                ->on('recurring_task_statuses')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recurring_task_activities');
    }
};
