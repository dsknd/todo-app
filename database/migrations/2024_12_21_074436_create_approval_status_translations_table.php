<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('approval_status_translations', function (Blueprint $table) {
            // カラム定義
            $table->unsignedBigInteger('approval_status_id');
            $table->unsignedBigInteger('locale_id');
            $table->string('name');
            $table->string('description');
            $table->timestamps();

            // 外部キー設定
            $table->foreign('approval_status_id')
                ->references('id')
                ->on('approval_statuses')
                ->cascadeOnDelete();

            $table->foreign('locale_id')
                ->references('id')
                ->on('locales')
                ->cascadeOnDelete();

            // 主キー
            $table->primary(['approval_status_id', 'locale_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('approval_status_translations');
    }
};