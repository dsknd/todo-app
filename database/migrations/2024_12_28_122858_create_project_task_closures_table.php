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
        Schema::create('project_task_closures', function (Blueprint $table) {
            $table->unsignedBigInteger('project_id'); // プロジェクトID
            $table->unsignedBigInteger('parent_id'); // 祖先のタスクID
            $table->unsignedBigInteger('child_id'); // 子孫のタスクID
            $table->unsignedInteger('depth'); // 深さ
            $table->timestamps();

            // 複合主キー
            $table->primary(['project_id', 'parent_id', 'child_id']);

            // 外部キー制約
            $table->foreign('parent_id')->references('task_id')->on('project_tasks')->onDelete('cascade');
            $table->foreign('child_id')->references('task_id')->on('project_tasks')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_task_closures');
    }
};
