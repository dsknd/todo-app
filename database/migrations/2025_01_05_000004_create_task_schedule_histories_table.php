<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('task_schedule_histories', function (Blueprint $table) {
            // カラム定義
            $table->unsignedBigInteger('history_id');
            $table->unsignedBigInteger('schedule_date_type_id');
            $table->datetime('from_date')->nullable();
            $table->datetime('to_date');
            $table->timestamps();

            // 外部キー制約
            $table->foreign('history_id')->references('id')->on('task_histories')->cascadeOnDelete();
            $table->foreign('schedule_date_type_id')->references('id')->on('schedule_date_types')->cascadeOnDelete();

            // 主キー制約
            $table->primary('history_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('task_schedule_histories');
    }
}; 