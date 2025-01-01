<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\QueryException;

/**
 * スコープテーブルを管理するためのマイグレーションクラス
 *
 * このテーブルは、アプリケーション全体で利用されるアクセス制御用スコープを管理します。
 * 各スコープは「リソース」(resource) と「アクション」(action) によって定義され、
 * 階層構造（parent_id）を使用してスコープ間の包含関係を表現します。
 *
 * 例:
 * - user:write スコープは user:read スコープを包含する
 * - project:admin は project:read と project:write を包含する
 *
 * このクラスは、スコープの作成、削除、階層的な依存関係の管理をサポートします。
 */
return new class extends Migration
{
    /**
     * スコープテーブルを作成
     * @return void
     * @throws QueryException
     */
    public function up(): void
    {
        Schema::create('scopes', function (Blueprint $table) {
            // カラム定義
            $table->id();
            $table->string('resource');                             // リソース名
            $table->string('action');                               // アクション名
            $table->string('name');                                 // スコープの名前
            $table->string('description')->nullable();              // スコープの説明
            $table->unsignedBigInteger('parent_id')->nullable();    // 親スコープID
            $table->timestamps();

            // 外部キー制約
            $table->foreign('parent_id')->references('id')->on('scopes')->cascadeOnDelete();

            // ユニーク制約
            $table->unique(['resource', 'action'], 'unique_resource_action');

        });
    }

    /**
     * スコープテーブルを削除
     * @return void
     * @throws QueryException
     */
    public function down(): void
    {
        Schema::dropIfExists('scopes');
    }
};
