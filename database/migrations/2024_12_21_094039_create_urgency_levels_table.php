<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('urgency_levels', function (Blueprint $table) {
            // テーブルコメント
            $table->comment('緊急度レベルテーブル');

            // カラム定義
            $table->unsignedBigInteger('id')->comment('緊急度レベルID');
            $table->string('display_name')->comment('緊急度の名称');
            $table->integer('urgency_level')->comment('緊急度レベル');
            $table->text('description')->nullable()->comment('緊急度の説明');
            $table->timestamps();

            // 主キー設定
            $table->primary('id');

            // ユニーク制約
            $table->unique('urgency_level');

            // インデックス
            $table->index('urgency_level');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('urgency_levels');
    }
}; 