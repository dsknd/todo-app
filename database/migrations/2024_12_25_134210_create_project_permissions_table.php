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
        Schema::create('project_permissions', function (Blueprint $table) {
            // カラム定義
            $table->unsignedBigInteger('permission_id'); // パーミッションID
            $table->timestamps();

            // 外部キー制約
            $table->foreign('permission_id')->references('id')->on('permissions')->cascadeOnDelete();

            // 主キー制約
            $table->primary('permission_id');
        });
    }

    /**
     * プロジェクトスコープテーブルを削除
     * @return void
     * @throws QueryException
     */
    public function down(): void
    {
        Schema::dropIfExists('project_permissions');
    }
};
