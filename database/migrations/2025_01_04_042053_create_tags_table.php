<?php

use App\Enums\OwnershipTypeEnum;
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
            $table->id()->comment('タグID');
            $table->string('name')->comment('タグ名');
            $table->text('description')->nullable()->comment('タグの説明');

            // 所有情報
            $table->unsignedBigInteger('user_id')->comment('作成者');

            $table->unsignedBigInteger('project_id')->comment('プロジェクトID');

            $table->timestamps();

            // 外部キー制約
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();

            $table->foreign('project_id')
                ->references('id')
                ->on('projects')
                ->cascadeOnDelete();

            // インデックス
            $table->index('user_id');
            $table->index('project_id');
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
