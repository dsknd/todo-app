<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * プロジェクトロールタイプの翻訳テーブルを作成
 */
return new class extends Migration
{
    /**
     * プロジェクトロールテーブルを作成
     */
    public function up(): void
    {
        Schema::create('project_role_type_translations', function (Blueprint $table) {
            // カラム定義
            $table->unsignedBigInteger('project_role_type_id');
            $table->unsignedBigInteger('locale_id');
            $table->string('name');
            $table->string('description');
            $table->timestamps();

            // 外部キー定義
            $table->foreign('project_role_type_id', 'project_role_type_translations_project_role_type_id_fk')
                ->references('id')
                ->on('project_role_types')
                ->cascadeOnDelete();

            $table->foreign('locale_id', 'project_role_type_translations_locale_id_fk')
                ->references('id')
                ->on('locales')
                ->cascadeOnDelete();

            // 主キー定義
            $table->primary(['project_role_type_id', 'locale_id']);

            // インデックス定義
            $table->index('locale_id');
        });
    }

    /**
     * プロジェクトロールテーブルを削除
     */
    public function down(): void
    {
        Schema::dropIfExists('project_role_type_translations');
    }
};
