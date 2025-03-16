<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * アプリケーションログテーブルを作成
     */
    public function up(): void
    {
        Schema::create('app_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('action');                    // 実行されたアクション
            $table->string('loggable_type');            // ログ対象のモデルタイプ
            $table->unsignedBigInteger('loggable_id');  // ログ対象のモデルID
            $table->string('description')->nullable();   // アクションの説明
            $table->json('details')->nullable();         // 詳細情報
            $table->string('ip_address')->nullable();    // IPアドレス
            $table->string('user_agent')->nullable();    // ユーザーエージェント
            $table->string('severity')->default('info'); // ログの重要度
            $table->timestamps();

            // 外部キー制約
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->nullOnDelete();

            // インデックス
            $table->index(['loggable_type', 'loggable_id']);
            $table->index('action');
            $table->index('severity');
        });
    }

    /**
     * アプリケーションログテーブルを削除
     */
    public function down(): void
    {
        Schema::dropIfExists('app_logs');
    }
};
