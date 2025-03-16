<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('task_priority_histories', function (Blueprint $table) {
            // カラム定義
            $table->unsignedBigInteger('history_id');
            $table->unsignedBigInteger('from_priority_id')->nullable();
            $table->unsignedBigInteger('to_priority_id');

            // 外部キー制約
            $table->foreign('history_id')->references('id')->on('task_histories')->cascadeOnDelete();
            $table->foreign('from_priority_id')->references('id')->on('priorities');
            $table->foreign('to_priority_id')->references('id')->on('priorities');

            // 主キー制約
            $table->primary('history_id');

            // インデックス
            $table->index('from_priority_id');
            $table->index('to_priority_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('task_priority_histories');
    }
}; 