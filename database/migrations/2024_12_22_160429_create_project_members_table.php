<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\QueryException;

return new class extends Migration
{
    /**
     * プロジェクトメンバーテーブルを作成
     * @return void
     * @throws QueryException
     */
    public function up(): void
    {
        Schema::create('project_members', function (Blueprint $table) {
            // カラム定義
            $table->unsignedBigInteger('project_id');      // プロジェクトID
            $table->unsignedBigInteger('user_id');         // ユーザID
            $table->timestamp('joined_at')->useCurrent(); // プロジェクト参画日時

            // 外部キー制約
            $table->foreign('project_id')->references('id')->on('projects')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();

            // 主キー制約
            $table->primary(['project_id', 'user_id']);

            // インデックス
            $table->index('user_id');
        });
    }

    /**
     * プロジェクトメンバーテーブルを削除
     * @return void
     * @throws QueryException
     */
    public function down():void
    {
        Schema::dropIfExists('project_members');
    }
};
