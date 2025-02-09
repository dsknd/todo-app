<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('milestone_priorities', function (Blueprint $table) {
            // カラム定義
            $table->unsignedBigInteger('id');
            $table->string('key');
            $table->unsignedInteger('priority_value');
            $table->timestamps();

            // 主キー
            $table->primary('id');

            // インデックス
            $table->unique('key');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('milestone_priorities');
    }
}; 