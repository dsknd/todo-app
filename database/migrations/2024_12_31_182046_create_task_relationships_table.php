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
        Schema::create('task_relationships', function (Blueprint $table) {
            // カラム定義
            $table->unsignedBigInteger('parent_task_id'); // 親タスクID
            $table->unsignedBigInteger('child_task_id');  // 子タスクID
            $table->unsignedInteger('depth');             // 階層
            $table->timestamps();                                 // 作成日時と更新日時

            // 外部キー制約
            $table->foreign('parent_task_id')
                ->references('id')
                ->on('tasks')
                ->cascadeOnDelete();

            $table->foreign('child_task_id')
                ->references('id')
                ->on('tasks')
                ->cascadeOnDelete();

            // 主キー制約
            $table->primary(['parent_task_id', 'child_task_id']);
        });
    }

    /**
     * タスクの親子関係テーブルを削除
     * @return void
     * @throws QueryException
     */
    public function down(): void
    {
        Schema::dropIfExists('task_relationships');
    }
};
