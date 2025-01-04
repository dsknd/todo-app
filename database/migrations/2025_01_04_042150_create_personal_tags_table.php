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
        Schema::create('personal_tags', function (Blueprint $table) {
            // カラム定義
            $table->unsignedBigInteger('tag_id');          // タグID
            $table->unsignedBigInteger('user_id');  // ユーザーID

            // 主キーの設定
            $table->primary('tag_id');

            // 外部キー設定
            $table->foreign('tag_id')->references('id')->on('tags')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();

            // インデックス設定
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_tags');
    }
};
