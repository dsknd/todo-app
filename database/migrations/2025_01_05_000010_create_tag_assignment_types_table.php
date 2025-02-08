<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tag_assignment_types', function (Blueprint $table) {
            // カラム定義
            $table->unsignedBigInteger('id');
            $table->string('key');
            $table->timestamps();

            // 主キー制約
            $table->primary('id');

            // ユニーク設定
            $table->unique('key');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tag_assignment_types');
    }
}; 