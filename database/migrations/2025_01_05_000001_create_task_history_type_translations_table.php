<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('task_history_type_translations', function (Blueprint $table) {
            $table->unsignedBigInteger('task_history_type_id');
            $table->unsignedBigInteger('locale_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();

            // 主キー制約
            $table->primary(['task_history_type_id', 'locale_id']);

            // インデックス
            $table->index('locale_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('task_history_type_translations');
    }
}; 