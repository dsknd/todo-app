<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedule_date_types', function (Blueprint $table) {
            // カラム定義
            $table->unsignedBigInteger('id');
            $table->string('key');
            $table->timestamps();

            // 主キー制約
            $table->primary('id');

            // ユニーク制約
            $table->unique('key');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedule_date_types');
    }
}; 