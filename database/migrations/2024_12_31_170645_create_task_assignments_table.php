<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\QueryException;

/**
 * プロジェクトのタスク割り当て情報を管理するためのマイグレーションクラス
 */
return new class extends Migration
{
    /**
     * プロジェクトタスク割り当てテーブルを作成
     * @return void
     * @throws QueryException
     */
    public function up(): void
    {
        Schema::create('task_assignments', function (Blueprint $table){
            // カラム定義
            $table->unsignedBigInteger('task_id');    // タスク
            $table->unsignedBigInteger('project_id'); // プロジェクト
            $table->unsignedBigInteger('assigned_user_id');        // 割り当てたユーザ
            $table->unsignedBigInteger('assigner_user_id');        // 割り当てられたユーザ
            $table->timestamps();

            // 外部キー制約

            $table->foreign(['project_id', 'assigned_user_id'])
                ->references(['project_id', 'user_id'])
                ->on('project_members')
                ->cascadeOnDelete();

            $table->foreign(['project_id', 'assigner_user_id'])
                ->references(['project_id', 'user_id'])
                ->on('project_members')
                ->cascadeOnDelete();

            // 主キー制約
            $table->primary(['task_id', 'project_id', 'assigned_user_id']);
        });
    }

    /**
     * プロジェクトタスク割り当てテーブルを削除
     * @return void
     * @throws QueryException
     */
    public function down(): void
    {
        Schema::dropIfExists('task_assignments');
    }
};
