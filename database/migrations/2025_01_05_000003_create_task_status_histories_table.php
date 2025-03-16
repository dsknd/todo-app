<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('task_status_histories', function (Blueprint $table) {
            // カラム定義
            $table->unsignedBigInteger('history_id');
            $table->unsignedBigInteger('from_status_id');
            $table->unsignedBigInteger('to_status_id');

            // 外部キー設定
            $table->foreign('history_id')->references('id')->on('task_histories');
            $table->foreign('from_status_id')->references('id')->on('task_statuses');
            $table->foreign('to_status_id')->references('id')->on('task_statuses');

            // 主キー設定
            $table->primary('history_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('task_status_histories');
    }
}; 