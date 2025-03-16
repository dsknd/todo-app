<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\QueryException;

/**
 * スコープテーブルを管理するためのマイグレーションクラス
 */
return new class extends Migration
{
    /**
     * テーブルを作成
     */
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            // カラム定義
            $table->unsignedBigInteger('id')->primary();                // ID（手動）
            $table->string('scope');                         // スコープ 例: projects:tasks:admin
            $table->string('resource');                      // リソース 例: projects.tasks
            $table->string('action');                        // アクション 例: admin
            $table->timestamps();                            // 作成日時、更新日時

            // ユニーク制約
            $table->unique(['scope', 'resource', 'action']);

            // インデックス
            $table->index('resource');
            $table->index('action');
        });
    }
    
    /**
     * テーブルを削除
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
