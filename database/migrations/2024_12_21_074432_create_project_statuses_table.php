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
        Schema::create('project_statuses', function (Blueprint $table) {
            $table->unsignedBigInteger('id');        // ID(手動)
            $table->string('display_name');                  // 表示名
            $table->text('description')->nullable(); // 説明
            $table->timestamps();                    // 作成・更新日時

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
        Schema::dropIfExists('project_statuses');
    }
};
