<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * マイルストーンとタスクの関連を管理するマイグレーション
 */
return new class extends Migration
{
    /**
     * マイルストーンタスクテーブルを作成
     */
    public function up(): void
    {
        Schema::create('milestone_assignments', function (Blueprint $table) {
            // カラム定義
            $table->unsignedBigInteger('milestone_id');
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('task_number');
            
            $table->timestamps();

            // 外部キー制約
            $table->foreign('milestone_id')
                ->references('id')
                ->on('milestones')
                ->cascadeOnDelete();
            
            $table->foreign(['project_id', 'task_number'])
                ->references(['project_id', 'task_number'])
                ->on('tasks')
                ->cascadeOnDelete();

            // 主キー制約
            $table->primary(['milestone_id', 'project_id', 'task_number']);
        });
    }

    /**
     * ロールバック時の処理
     */
    public function down(): void
    {
        Schema::dropIfExists('milestone_assignments');
    }
};