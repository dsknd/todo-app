<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invitation_type_translations', function (Blueprint $table) {
            // カラム定義
            $table->unsignedBigInteger('invitation_type_id');
            $table->unsignedBigInteger('locale_id');
            $table->string('name');
            $table->string('description');
            $table->timestamps();

            // 外部キー設定
            $table->foreign('invitation_type_id')
                ->references('id')
                ->on('invitation_types')
                ->cascadeOnDelete();

            $table->foreign('locale_id')
                ->references('id')
                ->on('locales')
                ->cascadeOnDelete();

            // 主キー設定
            $table->primary(['invitation_type_id', 'locale_id']);

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invitation_type_translations');
    }
}; 