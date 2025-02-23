<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invitation_status_translations', function (Blueprint $table) {
            // カラム定義
            $table->unsignedBigInteger('invitation_status_id');
            $table->unsignedBigInteger('locale_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();

            // 外部キー設定
            $table->foreign('invitation_status_id')
                ->references('id')
                ->on('invitation_statuses')
                ->cascadeOnDelete();

            $table->foreign('locale_id')
                ->references('id')
                ->on('locales')
                ->cascadeOnDelete();

            // 主キー設定
            $table->primary(['invitation_status_id', 'locale_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invitation_status_translations');
    }
}; 