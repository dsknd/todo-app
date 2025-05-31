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
            $table->id();                                    // 主キーID（AUTO_INCREMENT）
            $table->unsignedBigInteger('project_id');        // プロジェクトID
            $table->unsignedBigInteger('user_id');           // ユーザID
            $table->unsignedBigInteger('role_id');           // ロールID
            $table->timestamp('joined_at')->useCurrent();    // プロジェクト参画日時
            $table->timestamps();                            // 作成日時, 更新日時

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

            // ユニークキー制約（重複メンバー防止）
            $table->unique(['project_id', 'user_id']);

            // インデックス
            $table->index('role_id');
            $table->index('user_id');
            $table->index('joined_at');
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
