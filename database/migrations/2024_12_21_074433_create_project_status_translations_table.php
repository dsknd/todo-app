<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_status_translations', function (Blueprint $table) {
            // カラム定義
            $table->unsignedBigInteger('project_status_id');
            $table->unsignedBigInteger('locale_id');
            $table->string('name');
            $table->string('description');
            $table->timestamps();

            // 外部キー設定
            $table->foreign('project_status_id')
                ->references('id')
                ->on('project_statuses')
                ->cascadeOnDelete();

            // 主キー設定
            $table->primary(['project_status_id', 'locale_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_status_translations');
    }
}; 