<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * マイルストーンの依存関係を管理するマイグレーション
 */
return new class extends Migration
{
    /**
     * マイルストーンの依存関係テーブルを作成
     */
    public function up(): void
    {
        Schema::create('milestone_dependencies', function (Blueprint $table) {
            $table->unsignedBigInteger('dependent_milestone_id');    // 依存する側
            $table->unsignedBigInteger('dependency_milestone_id');   // 依存される側
            $table->string('dependency_type')                        // 依存タイプ
                ->default('FS');                                     // Finish to Start
            $table->integer('lag_minutes')                          // 遅延（分）
                ->default(0);
            $table->timestamps();

            // 外部キー制約
            $table->foreign('dependent_milestone_id')
                ->references('id')
                ->on('milestones')
                ->cascadeOnDelete();

            $table->foreign('dependency_milestone_id')
                ->references('id')
                ->on('milestones')
                ->cascadeOnDelete();

            // 主キー制約
            $table->primary(['dependent_milestone_id', 'dependency_milestone_id']);
        });
    }

    /**
     * ロールバック時の処理
     */
    public function down(): void
    {
        Schema::dropIfExists('milestone_dependencies');
    }
};
