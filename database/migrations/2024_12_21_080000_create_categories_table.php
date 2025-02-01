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
        Schema::create('categories', function (Blueprint $table) {
            // カラム定義
            $table->unsignedBigInteger('id');                             // ID(手動)
            $table->string('name');                                       // 表示名
            $table->text('description')->nullable();                      // 説明
            $table->timestamps();                                         // 作成日時と更新日時

            // 主キー制約
            $table->primary('id');

            // ユニーク制約
            $table->unique('name');
        });
    }

    /**
     * タスクカテゴリテーブルを削除
     * @return void
     * @throws QueryException
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
