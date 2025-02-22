<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('task_approval_statuses', function (Blueprint $table) {
            // カラム定義
            $table->id();
            $table->string('key');
            $table->timestamps();

            // 主キー定義
            $table->primary('id');

            // ユニークキー定義
            $table->unique('key');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('task_approval_statuses');
    }
}; 