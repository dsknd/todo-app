<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_statistics', function (Blueprint $table) {
            $table->foreignId('project_id')->primary()->constrained()->cascadeOnDelete();
            
            // タスク数の集計
            $table->integer('total_tasks_count')->default(0);
            $table->integer('completed_tasks_count')->default(0);
            $table->integer('in_progress_tasks_count')->default(0);
            $table->integer('pending_tasks_count')->default(0);
            $table->integer('cancelled_tasks_count')->default(0);
            $table->integer('on_hold_tasks_count')->default(0);
            $table->integer('overdue_tasks_count')->default(0);
            
            // 進捗率（0-100）
            $table->decimal('progress_rate', 5, 2)->default(0);
            
            // 予定と実績
            $table->integer('total_estimated_minutes')->default(0);
            $table->integer('total_actual_minutes')->default(0);
            
            // 優先度の分布
            $table->json('priority_distribution')->nullable();
            
            // カテゴリ分布
            $table->json('category_distribution')->nullable();
            
            // 最終更新日時
            $table->timestamp('last_task_updated_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_statistics');
    }
}; 