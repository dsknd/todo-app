<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\QueryException;

/**
 * タスクカテゴリを管理するためのマイグレーションクラス
 *
 * このテーブルでは、タスクのカテゴリを管理します。
 * カテゴリには、個人カテゴリとプロジェクトカテゴリの2種類があります。
 * 個人カテゴリは、ユーザーごとに作成されるカテゴリであり、プロジェクトカテゴリは、プロジェクトごとに作成されるカテゴリです。
 * プロジェクトカテゴリは、プロジェクトIDを持つことができます。
 */
return new class extends Migration
{
    /**
     * タスクカテゴリテーブルを作成
     * @return void
     * @throws QueryException
     */
    public function up(): void
    {
        Schema::create('task_categories', function (Blueprint $table) {
            // カラム定義
            $table->id();                                                 // ID
            $table->string('name');                               // カテゴリ名
            $table->text('description')->nullable();              // 説明
            $table->boolean('is_personal')->default(false); // 個人カテゴリかどうか
            $table->boolean('is_project')->default(false);  // プロジェクトカテゴリかどうか
            $table->unsignedBigInteger('project_id')->nullable(); // プロジェクトID("is_project"がtrueの場合のみ)
            $table->unsignedBigInteger('created_by');             // 作成者
            $table->timestamps();                                         // 作成日時と更新日時

            // 外部キー制約
            $table->foreign('created_by')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('project_id')->references('id')->on('projects')->cascadeOnDelete();
        });
    }

    /**
     * タスクカテゴリテーブルを削除
     * @return void
     * @throws QueryException
     */
    public function down(): void
    {
        Schema::dropIfExists('task_categories');
    }
};
