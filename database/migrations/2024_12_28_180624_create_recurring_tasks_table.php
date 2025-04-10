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
        Schema::create('recurring_tasks', function (Blueprint $table) {
            // カラム定義
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('task_number');

            $table->json('rrule')->notNullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // 外部キー設定
            $table->foreign(['project_id', 'task_number'])
                ->references(['project_id', 'task_number'])
                ->on('tasks')
                ->cascadeOnDelete();

            // 主キー設定
            $table->primary(['project_id', 'task_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recurring_tasks');
    }
};
