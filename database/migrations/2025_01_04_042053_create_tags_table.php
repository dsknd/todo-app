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
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();

            // 所有情報
            $table->unsignedBigInteger('ownership_type_id');

            $table->unsignedBigInteger('created_by');          // 作成者/所有者

            $table->timestamps();

            // 外部キー制約
            $table->foreign('created_by')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();

            $table->foreign('ownership_type_id')
                ->references('id')
                ->on('ownership_types')
                ->cascadeOnDelete();

            // インデックス
            $table->index('ownership_type_id');
            $table->index('created_by');
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
