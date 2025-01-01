<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\QueryException;

/**
 * プロジェクトで適用できるスコープを管理するためのテーブル
 */
return new class extends Migration
{
    /**
     * プロジェクトスコープテーブルを作成
     * @return void
     * @throws QueryException
     */
    public function up(): void
    {
        Schema::create('project_scopes', function (Blueprint $table) {
            // カラム定義
            $table->unsignedBigInteger('scope_id'); // スコープID

            // 外部キー制約
            $table->foreign('scope_id')->references('id')->on('scopes')->cascadeOnDelete();

            // 主キー制約
            $table->primary('scope_id');
        });
    }

    /**
     * プロジェクトスコープテーブルを削除
     * @return void
     * @throws QueryException
     */
    public function down(): void
    {
        Schema::dropIfExists('project_scopes');
    }
};
