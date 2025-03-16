<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('task_tag_histories', function (Blueprint $table) {
            // カラム定義
            $table->unsignedBigInteger('history_id');
            $table->unsignedBigInteger('tag_id');
            $table->unsignedBigInteger('tag_assignment_type_id');

            // 外部キー制約
            $table->foreign('history_id')->references('id')->on('task_histories')->cascadeOnDelete();
            $table->foreign('tag_id')->references('id')->on('tags');
            $table->foreign('tag_assignment_type_id')->references('id')->on('tag_assignment_types');
            // 主キー制約
            $table->primary('history_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('task_tag_histories');
    }
}; 