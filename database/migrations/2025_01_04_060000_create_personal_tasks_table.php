<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('personal_tasks', function (Blueprint $table) {
            // テーブルコメント
            $table->comment('個人タスクテーブル');

            // カラム定義
            $table->unsignedBigInteger('task_id')->comment('タスクID');
            $table->unsignedBigInteger('user_id')->comment('ユーザーID');

            // 外部キー制約
            $table->foreign('task_id')->references('id')->on('tasks')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();

            // インデックス
            $table->index('task_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personal_tasks');
    }
}; 