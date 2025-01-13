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
        Schema::create('project_invitation_statuses', function (Blueprint $table) {
            // カラム定義
            $table->unsignedBigInteger('id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();

            // 主キー制約
            $table->primary('id');

            // ユニーク制約
            $table->unique('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_invitation_statuses');
    }
};
