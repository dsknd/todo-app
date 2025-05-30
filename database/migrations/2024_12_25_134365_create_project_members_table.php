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
            $table->unsignedBigInteger('project_id');        // プロジェクトID
            $table->unsignedBigInteger('user_id');           // ユーザID
            $table->unsignedBigInteger('role_id');           // ロールID
            $table->timestamp('joined_at', 6)->useCurrent(); // プロジェクト参画日時（マイクロ秒精度）
            $table->timestamps(6);                           // 作成日時, 更新日時（マイクロ秒精度）

            // 外部キー制約
            $table->foreign('project_id')
                ->references('id')
                ->on('projects')
                ->cascadeOnDelete();
            
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();

            $table->foreign('role_id')
                ->references('id')
                ->on('project_roles')
                ->cascadeOnDelete();

            // 主キー制約
            $table->primary(['project_id', 'user_id']);

            // インデックス
            $table->index('role_id');
            $table->index('user_id');
            $table->index('joined_at');
            $table->index('created_at');
        });
    }

    /**
     * プロジェクトメンバーテーブルを削除
     * @return void
     * @throws QueryException
     */
    public function down(): void
    {
        Schema::dropIfExists('project_members');
    }
};
