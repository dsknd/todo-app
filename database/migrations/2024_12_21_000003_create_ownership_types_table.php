<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ownership_types', function (Blueprint $table) {
            // カラム定義
            $table->unsignedBigInteger('id');
            $table->string('display_name');
            $table->text('description')->nullable();
            $table->timestamps();

            // 主キー制約
            $table->primary('id');

            // ユニーク制約
            $table->unique('display_name');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ownership_types');
    }
};
