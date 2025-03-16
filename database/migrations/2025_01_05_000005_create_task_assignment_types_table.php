<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('task_assignment_types', function (Blueprint $table) {
            // カラム定義
            $table->unsignedBigInteger('id');
            $table->string('key')->comment('システム内で使用する名称');
            $table->timestamps();

            // 主キー制約
            $table->primary('id');

            // テーブルコメント
            $table->comment('タスク担当者変更履歴の種別');

            // ユニーク制約
            $table->unique('key');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('task_assignment_types');
    }
}; 