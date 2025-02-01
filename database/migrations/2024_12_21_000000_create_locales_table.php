<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('locales', function (Blueprint $table) {
            // カラム定義
            $table->unsignedBigInteger('id');
            $table->string('code_iso_639_1');
            $table->string('code_ietf_bcp_47');
            $table->string('name');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // 主キー制約
            $table->primary('id');

            // ユニーク制約
            $table->unique('code_iso_639_1');
            $table->unique('code_ietf_bcp_47');
            // インデックス
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('locales');
    }
}; 