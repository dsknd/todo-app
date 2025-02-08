<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('task_importance_histories', function (Blueprint $table) {
            // カラム定義
            $table->unsignedBigInteger('history_id');
            $table->unsignedBigInteger('from_importance_id')->nullable();
            $table->unsignedBigInteger('to_importance_id');

            // 外部キー制約
            $table->foreign('history_id')->references('id')->on('task_histories')->cascadeOnDelete();
            $table->foreign('from_importance_id')->references('id')->on('importance_levels');
            $table->foreign('to_importance_id')->references('id')->on('importance_levels');

            // 主キー制約
            $table->primary('history_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('task_importance_histories');
    }
}; 