<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('task_title_histories', function (Blueprint $table) {
            // カラム定義
            $table->unsignedBigInteger('history_id');
            $table->string('from_title')->nullable();
            $table->string('to_title');
            $table->timestamps();
            
            // 外部キー制約
            $table->foreign('history_id')
                ->references('id')
                ->on('task_histories')
                ->cascadeOnDelete();

            // 主キー制約
            $table->primary('history_id');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('task_histories');
    }
}; 