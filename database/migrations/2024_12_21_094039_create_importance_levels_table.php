<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('importance_levels', function (Blueprint $table) {
            // テーブルコメント
            $table->comment('重要度レベルテーブル');

            // カラム定義
            $table->unsignedBigInteger('id')->comment('重要度レベルID');
            $table->string('display_name')->comment('重要度の名称');
            $table->integer('importance_level')->comment('重要度レベル');
            $table->text('description')->nullable()->comment('重要度の説明');
            $table->timestamps();

            // 主キー設定
            $table->primary('id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('importance_levels');
    }
}; 