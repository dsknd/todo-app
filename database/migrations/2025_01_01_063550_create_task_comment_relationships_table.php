<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\QueryException;


/**
 * タスクへのコメントの親子関係を管理するためのマイグレーションクラス
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
        Schema::create('task_comment_relationships', function (Blueprint $table) {
            // カラム定義
            $table->unsignedBigInteger('parent_id'); // 親タスクID
            $table->unsignedBigInteger('child_id');  // 子タスクID
            $table->unsignedInteger('depth');        // 階層
            $table->timestamps();

            // 外部キー制約
            $table->foreign('parent_id')->references('id')->on('task_comments')->cascadeOnDelete();
            $table->foreign('child_id')->references('id')->on('task_comments')->cascadeOnDelete();

            // 主キー制約
            $table->primary(['parent_id', 'child_id']);
        });
    }

    /**
     * タスクの親子関係テーブルを削除
     * @return void
     * @throws QueryException
     */
    public function down(): void
    {
        Schema::dropIfExists('task_comment_relationships');
    }
};
