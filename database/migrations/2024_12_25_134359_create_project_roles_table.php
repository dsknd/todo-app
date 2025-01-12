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
 *
 * また、scopesカラムには、各ロールに適用されるスコープのリストをJSON形式で保持します。
 * (例) ["project:read", "project:write", "task:read", "task:write"]
 */
return new class extends Migration
{
    /**
     * プロジェクトロールテーブルを作成
     */
    public function up(): void
    {
        Schema::create('project_roles', function (Blueprint $table) {
            // カラム定義
            $table->id();
            $table->string('name');                                        // ロール名
            $table->string('description')->nullable();                     // ロールの説明
            $table->unsignedBigInteger('project_id');                      // プロジェクトID
            $table->unsignedBigInteger('project_permission_id');           // 権限ID   
            $table->timestamps();                                          // 作成日時、更新日時

            // 外部キー制約
            $table->foreign('project_id')->references('id')->on('projects')->cascadeOnDelete();
            $table->foreign('project_permission_id')->references('permission_id')->on('project_permissions')->cascadeOnDelete();

            // ユニーク制約
            $table->unique(['project_id', 'name']);

            // インデックス
            $table->index('project_id');
            $table->index('project_permission_id');
        });
    }

    /**
     * プロジェクトロールテーブルを削除
     */
    public function down(): void
    {
        Schema::dropIfExists('project_roles');
    }
};
