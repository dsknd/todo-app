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
            $table->id()->comment('ID');
            $table->string('key')->comment('ステータス名');
            $table->timestamps();

            // 主キー設定
            $table->primary('id');
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
