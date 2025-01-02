<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


/**
 * プロジェクトを管理するためのマイグレーションクラス
 */
return new class extends Migration
{
    /**
     * プロジェクトテーブルを作成します。
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            // カラム定義
            $table->id();                                                             // プロジェクトID
            $table->string('name');                                           // プロジェクト名
            $table->text('description')->nullable();                          // プロジェクトの説明
            $table->date('start_date')->nullable();                           // 開始日
            $table->date('end_date')->nullable();                             // 終了日
            $table->unsignedBigInteger('status_id');                          // ステータスID
            $table->unsignedInteger('member_count')->default(0);        // メンバー数
            $table->unsignedInteger('task_count')->default(0);          // タスク数
            $table->unsignedBigInteger('created_by');                         // 作成者
            $table->timestamps();                                                     // 作成日時、更新日時

            // 外部キー制約
            $table->foreign('status_id')->references('id')->on('project_statuses')->cascadeOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * プロジェクトテーブルを削除します。
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
