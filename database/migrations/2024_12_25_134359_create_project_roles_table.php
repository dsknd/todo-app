<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\QueryException;

/**
 * プロジェクトごとのロールを管理するためのマイグレーションクラス
 *
 * このテーブルは、プロジェクトごとに異なるロールを定義するためのものです。
 * 例えば、プロジェクトAでは「管理者」「編集者」「閲覧者」の3つのロールを定義し、
 * プロジェクトBでは「管理者」「編集者」「閲覧者」「ゲスト」の4つのロールを定義することができます。
 */
return new class extends Migration
{
    /**
     * プロジェクトロールテーブルを作成
     * @return void
     * @throws QueryException
     */
    public function up(): void
    {
        Schema::create('project_roles', function (Blueprint $table) { // `$table` をコールバック引数として明示
            // カラム定義
            $table->id();
            $table->string('name');                     // ロール名
            $table->string('description')->nullable();  // ロールの説明
            $table->unsignedBigInteger('project_id');   // プロジェクトID
            $table->timestamps();                               // 作成日時、更新日時

            // 外部キー制約
            $table->foreign('project_id')->references('id')->on('projects')->cascadeOnDelete();

            // ユニーク制約
            $table->unique(['project_id', 'name']);
        });
    }

    /**
     * プロジェクトロールテーブルを削除
     * @return void
     * @throws QueryException
     */
    public function down(): void
    {
        Schema::dropIfExists('project_roles');
    }
};
