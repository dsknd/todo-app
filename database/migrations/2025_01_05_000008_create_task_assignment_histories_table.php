<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('task_assignment_histories', function (Blueprint $table) {
            // カラム定義
            $table->unsignedBigInteger('history_id');
            $table->unsignedBigInteger('user_id')->comment('担当者ID');
            $table->unsignedBigInteger('type_id')->comment('種別ID');
            // 外部キー制約
            $table->foreign('history_id')->references('id')->on('task_histories')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('type_id')->references('id')->on('task_assignment_types');

            // 主キー制約
            $table->primary('history_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('task_assignment_histories');
    }
}; 