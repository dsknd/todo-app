<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\QueryException;


/**
 * プロジェクトのロールとスコープの割当情報を管理するためのマイグレーションクラス
 */
return new class extends Migration
{
    /**
     * プロジェクトロールスコープテーブルを作成
     * @return void
     * @throws QueryException
     */
    public function up(): void
    {
        Schema::create('project_role_scopes', function (Blueprint $table) {
            // カラム定義
            $table->unsignedBigInteger('role_id');  // ロールID
            $table->unsignedBigInteger('scope_id'); // スコープID
            $table->timestamps();

            // 外部キー制約
            $table->foreign('role_id')->references('id')->on('project_roles')->cascadeOnDelete();
            $table->foreign('scope_id')->references('scope_id')->on('project_scopes')->cascadeOnDelete();

            // 主キー制約
            $table->primary(['role_id', 'scope_id'], 'project_role_scope_primary');
        });
    }

    /**
     * プロジェクトロールスコープテーブルを削除
     * @return void
     * @throws QueryException
     */
    public function down(): void
    {
        Schema::dropIfExists('project_role_scopes');
    }
};
