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
        Schema::create('permission_closures', function (Blueprint $table) {
            // カラム定義
            $table->unsignedBigInteger('ancestor_id');
            $table->unsignedBigInteger('descendant_id');
            $table->integer('depth');
            $table->timestamps();

            // 主キー制約
            $table->primary(['ancestor_id', 'descendant_id']);

            // 外部キー制約
            $table->foreign('ancestor_id')->references('id')->on('permissions')->cascadeOnDelete();
            $table->foreign('descendant_id')->references('id')->on('permissions')->cascadeOnDelete();

            // インデックス
            $table->index('depth');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permission_closures');
    }
};
