<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('category_translations', function (Blueprint $table) {
            // カラム定義
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('locale_id');
            $table->string('name');
            $table->string('description');
            $table->timestamps();

            // 外部キー定義
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('locale_id')->references('id')->on('locales');

            // 主キー定義
            $table->primary(['category_id', 'locale_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('category_translations');
    }
}; 