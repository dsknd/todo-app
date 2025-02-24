<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permission_translations', function (Blueprint $table) {
            // カラム定義
            $table->unsignedBigInteger('permission_id');
            $table->unsignedBigInteger('locale_id');
            $table->string('name');
            $table->text('description');
            $table->timestamps();

            // 外部キー定義
            $table->foreign('permission_id')
                ->references('id')
                ->on('permissions')
                ->cascadeOnDelete();

            $table->foreign('locale_id')
                ->references('id')
                ->on('locales')
                ->cascadeOnDelete();

            // 主キー定義
            $table->primary(['permission_id', 'locale_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permission_translations');
    }
}; 