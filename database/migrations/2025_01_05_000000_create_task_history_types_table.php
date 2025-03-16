<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('task_history_types', function (Blueprint $table) {
            $table->id();
            $table->string('key');         // システム内部での識別子
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('task_history_types');
    }
}; 