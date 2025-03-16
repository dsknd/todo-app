<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tag_assignment_type_translations', function (Blueprint $table) {
            // カラム定義
            $table->unsignedBigInteger('tag_assignment_type_id');
            $table->foreignId('locale_id');
            $table->string('name');
            $table->string('description');
            $table->timestamps();

            // 外部キー定義
            $table->foreign('tag_assignment_type_id')
                ->references('id')
                ->on('tag_assignment_types')
                ->cascadeOnDelete();

            $table->foreign('locale_id')
                ->references('id')
                ->on('locales')
                ->cascadeOnDelete();

            // 主キー定義
            $table->primary(['tag_assignment_type_id', 'locale_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tag_assignment_type_translations');
    }
}; 