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
            $table->id();
            $table->foreignId('setting_id')->constrained('recurring_task_settings', 'task_id')->cascadeOnDelete();
            $table->timestamp('scheduled_at'); // 実行日時
            $table->foreignId('status_id')->constrained('recurring_task_statuses')->cascadeOnDelete(); // ステータス
            $table->timestamps();
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
