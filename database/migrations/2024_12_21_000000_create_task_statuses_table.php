<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     */
    public function up():void
    {
        // タスクのステータス
        Schema::create('task_statuses', function (Blueprint $table) {
            $table->id(); // プライマリキー
            $table->string('display_name')->unique(); // ステータス名
            $table->text('description')->nullable(); // 説明
            $table->timestamps(); // 作成・更新日時
        });
    }

    /**
     * Reverse the migrations.
     *
     */
    public function down():void
    {
        Schema::dropIfExists('task_statuses');
    }
};
