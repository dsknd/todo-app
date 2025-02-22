<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('priority_translations', function (Blueprint $table) {
            // カラム定義
            $table->unsignedBigInteger('priority_id');
            $table->unsignedBigInteger('locale_id');
            $table->string('name');
            $table->string('description');
            $table->timestamps();

            // 外部キー定義
            $table->foreign(['priority_id'])
                ->references(['id'])
                ->on('priorities')
                ->cascadeOnDelete();
                
            $table->foreign(['locale_id'])
                ->references(['id'])
                ->on('locales')
                ->cascadeOnDelete();

            // 主キー定義
            $table->primary(['priority_id', 'locale_id']);

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('priority_translations');
    }
}; 