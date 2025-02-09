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
 * - 進捗状況（達成状況）
 */
return new class extends Migration
{
    /**
     * マイルストーンテーブルを作成
     */
    public function up(): void
    {
        Schema::create('milestones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->string('name');                    // マイルストーン名
            $table->text('description')->nullable();   // 説明
            $table->datetime('due_date');             // 期日
            $table->unsignedBigInteger('priority_id'); // 優先度
            $table->boolean('is_achieved')->default(false); // 達成状況
            $table->timestamps();

            // 外部キー制約
            $table->foreign('project_id')
                ->references('id')
                ->on('projects')
                ->cascadeOnDelete();

            $table->foreign('priority_id')
                ->references('id')
                ->on('priorities')
                ->cascadeOnDelete();

            // インデックス
            $table->index('project_id');
            $table->index('due_date');
        });

    }

    /**
     * ロールバック時の処理
     */
    public function down(): void
    {
        Schema::dropIfExists('milestones');
    }
};