<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('task_statistics', function (Blueprint $table) {
            $table->foreignId('task_id')
                ->primary()
                ->constrained('tasks')
                ->cascadeOnDelete();
            
            // 作業時間
            $table->integer('estimated_minutes')->default(0);
            $table->integer('actual_minutes')->default(0);

            // 進捗率
            $table->decimal('progress', 5, 2)->default(0);
            
            // コメント数
            $table->integer('comments_count')->default(0);
            
            // 依存タスク数
            $table->integer('dependent_tasks_count')->default(0);  // このタスクに依存している数
            $table->integer('dependency_tasks_count')->default(0); // このタスクが依存している数
            
            // 変更履歴
            $table->integer('update_count')->default(0);
            $table->timestamp('last_updated_at')->nullable();
            
            // 期限関連
            $table->boolean('is_overdue')->default(false);
            $table->integer('overdue_days')->default(0);
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('task_statistics');
    }
}; 