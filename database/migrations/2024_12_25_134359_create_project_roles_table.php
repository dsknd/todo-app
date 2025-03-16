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
        Schema::create('project_roles', function (Blueprint $table) {
            // カラム定義
            $table->id();                                                                        // ID
            $table->unsignedBigInteger('project_role_type_id');                                  // プロジェクトロールタイプID
            $table->unsignedBigInteger('assignable_limit')->nullable();                          // 割当上限数
            $table->unsignedBigInteger('assigned_count')->default(0);                            // 割当数
            $table->timestamps();                                                                // 作成日時、更新日時

            // 外部キー定義
            $table->foreign('project_role_type_id')
                ->references('id')
                ->on('project_role_types')
                ->cascadeOnDelete();

            // インデックス定義
            $table->index('project_role_type_id');
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
