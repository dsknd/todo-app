<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('personal_task_closures', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id'); // ユーザーID
            $table->unsignedBigInteger('parent_id'); // 祖先のタスクID
            $table->unsignedBigInteger('child_id'); // 子孫のタスクID
            $table->unsignedInteger('depth'); // 深さ
            $table->primary(['user_id', 'parent_id', 'child_id']); // 複合主キー
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('parent_id')->references('task_id')->on('personal_tasks')->onDelete('cascade');
            $table->foreign('child_id')->references('task_id')->on('personal_tasks')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_task_closures');
    }
};
