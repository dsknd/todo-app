<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * タグを管理するテーブルを作成
     * 
     * このテーブルは以下の2種類のタグを管理します：
     * 1. プロジェクトタグ：特定のプロジェクトに属するタグ
     * 2. 個人タグ：特定のユーザーに属するタグ
     * 
     * また、タグは階層構造を持つことができます。
     */
    public function up(): void
    {
        Schema::create('tags', function (Blueprint $table) {
            // 基本情報
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('color', 7)->nullable();  // 色コード（例：#FF0000）

            // 所有情報
            $table->boolean('is_personal')->default(false);  // 個人タグかどうか
            $table->unsignedBigInteger('user_id');          // 作成者/所有者
            $table->unsignedBigInteger('project_id')->nullable();  // プロジェクトタグの場合のプロジェクトID

            // 階層構造
            $table->unsignedBigInteger('parent_tag_id')->nullable();  // 親タグID

            $table->timestamps();
            $table->softDeletes();

            // 外部キー制約
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();

            $table->foreign('project_id')
                ->references('id')
                ->on('projects')
                ->cascadeOnDelete();

            $table->foreign('parent_tag_id')
                ->references('id')
                ->on('tags')
                ->nullOnDelete();

            // インデックス
            $table->index(['is_personal', 'user_id']);
            $table->index(['project_id', 'parent_tag_id']);
        });
    }

    /**
     * タグテーブルを削除
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
