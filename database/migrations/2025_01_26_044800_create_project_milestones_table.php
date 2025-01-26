<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * プロジェクトのマイルストーンを管理するためのマイグレーション
 *
 * このテーブルは以下の情報を管理します：
 * - マイルストーンの基本情報（名前、説明、期日）
 * - プロジェクトとの関連
 * - マイルストーンの階層構造（親子関係）
 * - 進捗状況（達成状況、進捗率）
 */
return new class extends Migration
{
    /**
     * マイルストーンテーブルを作成
     */
    public function up(): void
    {
        Schema::create('project_milestones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->string('name');                    // マイルストーン名
            $table->text('description')->nullable();   // 説明
            $table->datetime('due_date');             // 期日
            $table->unsignedInteger('priority');      // 優先度（1-5）
            $table->boolean('is_achieved')->default(false); // 達成状況
            $table->decimal('progress', 5, 2)->default(0);  // 進捗率（0-100%）
            $table->unsignedBigInteger('parent_milestone_id')->nullable(); // 親マイルストーン
            $table->timestamps();
            $table->softDeletes();  // 論理削除

            // 外部キー制約
            $table->foreign('project_id')
                ->references('id')
                ->on('projects')
                ->cascadeOnDelete();

            $table->foreign('parent_milestone_id')
                ->references('id')
                ->on('project_milestones')
                ->nullOnDelete();

            // インデックス
            $table->index('project_id');
            $table->index('due_date');
            $table->index('parent_milestone_id');
        });

    }

    /**
     * ロールバック時の処理
     */
    public function down(): void
    {
        Schema::dropIfExists('project_milestones');
    }
};