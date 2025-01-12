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
     * テーブルを作成
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            // カラム定義
            $table->id();                                    // ID
            $table->string('scope');                         // スコープ 例: projects:tasks:admin
            $table->string('resource');                      // リソース 例: projects.tasks
            $table->string('action');                        // アクション 例: admin
            $table->string('display_name');                  // 表示名 例: プロジェクト管理者
            $table->string('description')->nullable();       // 説明
            $table->timestamps();                            // 作成日時、更新日時

            // ユニーク制約
            $table->unique(['scope']);

            // インデックス
            $table->index('resource');
            $table->index('action');
        });
    }
    
    /**
     * テーブルを削除
     */
    public function down()
    {
        Schema::dropIfExists('permissions');
    }
};
