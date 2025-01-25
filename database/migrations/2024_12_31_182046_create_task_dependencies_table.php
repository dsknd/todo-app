<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\QueryException;

/**
 * タスクの親子関係を管理するためのマイグレーションクラス
 */
return new class extends Migration
{
    /**
     * タスクの親子関係テーブルを作成
     * @return void
     * @throws QueryException
     */
    public function up(): void
    {
        Schema::create('task_dependencies', function (Blueprint $table) {
            // カラム定義
            $table->unsignedBigInteger('task_id'); // タスクID
            $table->unsignedBigInteger('dependency_task_id');  // 依存タスクID
            $table->timestamps();                                 // 作成日時と更新日時

            // 外部キー制約
            $table->foreign('task_id')
                ->references('id')
                ->on('tasks')
                ->cascadeOnDelete();

            $table->foreign('dependency_task_id')
                ->references('id')
                ->on('tasks')
                ->cascadeOnDelete();

            // 主キー制約
            $table->primary(['task_id', 'dependency_task_id']);
        });
    }

    /**
     * タスクの親子関係テーブルを削除
     * @return void
     * @throws QueryException
     */
    public function down(): void
    {
        Schema::dropIfExists('task_dependencies');
    }
};
