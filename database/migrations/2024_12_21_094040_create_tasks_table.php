<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\QueryException;

/**
 * タスクテーブルを管理するためのマイグレーションクラス
 *
 * このテーブルは、タスクの情報を管理するためのテーブルです。
 * タスクは、プロジェクトに紐づくタスクと個人に紐づくタスクの2種類があります。
 * タスクには、タイトル、詳細、期限日、タスクの種別、優先度、作成者、ステータス、プロジェクトID、継続タスクかどうかの情報が含まれます。
 *
 */
return new class extends Migration
{
    /**
     * タスクテーブルを作成
     * @return void
     * @throws QueryException
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            // カラム定義
            $table->id();                                           // ID
            $table->string('title');                                // タイトル
            $table->text('description')->nullable();                // 詳細
            $table->date('due_date')->nullable();                   // 期限日
            $table->unsignedBigInteger('ownership_type_id');        // 所有種別(project, personal)
            $table->unsignedBigInteger ('priority_id')->nullable(); // 優先度
            $table->unsignedBigInteger ('user_id');                 // 作成者
            $table->unsignedBigInteger('status_id')->nullable();    // ステータス
            $table->boolean('is_recurring')->default(false);        // 継続タスクかどうか
            $table->timestamps();                                   // 作成日時と更新日時

            //外部キー制約
            $table->foreign('ownership_type_id')->references('id')->on('ownership_types')->cascadeOnDelete();
            $table->foreign('priority_id')->references('id')->on('task_priorities')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('status_id')->references('id')->on('task_statuses')->cascadeOnDelete();
        });
    }

    /**
     * タスクテーブルを削除
     * @return void
     * @throws QueryException
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
