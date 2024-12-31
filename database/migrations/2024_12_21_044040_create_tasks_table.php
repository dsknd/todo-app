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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('due_date')->nullable();
            $table->foreignId('type_id')->constrained('task_types')->cascadeOnDelete(); // タスクの種類
            $table->foreignId('priority_id')->constrained('task_priorities')->cascadeOnDelete(); // 優先度
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete(); // 作成者
            $table->boolean('is_recurring')->default(false); // 継続タスクかどうか
            $table->foreignId('status_id')->constrained('task_statuses')->cascadeOnDelete(); // ステータス
            $table->timestamps(); // 作成日時と更新日時
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
