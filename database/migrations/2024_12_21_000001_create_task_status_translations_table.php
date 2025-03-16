<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('task_status_translations', function (Blueprint $table) {
            // カラム定義
            $table->unsignedBigInteger('task_status_id');
            $table->unsignedBigInteger('locale_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();

            // 主キー制約
            $table->primary(['task_status_id', 'locale_id']);

            // 外部キー制約
            $table->foreign('task_status_id')
                ->references('id')
                ->on('task_statuses')
                ->cascadeOnDelete();

            $table->foreign('locale_id')
                ->references('id')
                ->on('locales')
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('task_status_translations');
    }
}; 