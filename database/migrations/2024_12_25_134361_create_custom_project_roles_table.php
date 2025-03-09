<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
     */
    public function up(): void
    {
        Schema::create('custom_project_roles', function (Blueprint $table) {
            // カラム定義
            $table->unsignedBigInteger('project_role_id');                                       // プロジェクトロールID
            $table->string('name');                                                              // プロジェクトロール名
            $table->string('description')->nullable();                                           // プロジェクトロールの説明
            $table->timestamps();                                                                // 作成日時、更新日時

            // 外部キー定義
            $table->foreign('project_role_id')
                ->references('id')
                ->on('project_roles')
                ->cascadeOnDelete();

            // ユニーク定義
            $table->unique('name');

            // 主キー定義
            $table->primary('project_role_id');
        });
    }

    /**
     * プロジェクトロールテーブルを削除
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_project_roles');
    }
};
