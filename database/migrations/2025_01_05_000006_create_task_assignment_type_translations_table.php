<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('task_assignment_type_translations', function (Blueprint $table) {
            // カラム定義
            $table->unsignedBigInteger('task_assignment_type_id');
            $table->unsignedBigInteger('locale_id');
            $table->string('name');
            $table->string('description');
            $table->timestamps();

            // 外部キー設定
            $table->foreign('task_assignment_type_id', 'task_assignment_type_translations_task_assignment_type_id_fk')
                ->references('id')
                ->on('task_assignment_types')
                ->cascadeOnDelete();

            $table->foreign('locale_id', 'task_assignment_type_translations_locale_id_fk')
                ->references('id')
                ->on('locales')
                ->cascadeOnDelete();

            // 主キー設定
            $table->primary(['task_assignment_type_id', 'locale_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('task_assignment_type_translations');
    }
}; 