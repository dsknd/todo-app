<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invitation_types', function (Blueprint $table) {
            // カラム定義
            $table->unsignedBigInteger('id');
            $table->string('key')->comment('システム内部キー');
            $table->timestamps();

            // 主キー
            $table->primary('id');

            // ユニーク設定
            $table->unique('key');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invitation_types');
    }
}; 