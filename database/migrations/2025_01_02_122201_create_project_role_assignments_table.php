<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('project_role_assignments', function (Blueprint $table) {
            // カラム定義
            $table->unsignedBigInteger('role_id');    // ロールID
            $table->unsignedBigInteger('project_id'); // プロジェクトID
            $table->unsignedBigInteger('user_id');    // ユーザーID
            $table->timestamps();

            // 外部キー制約
            $table->foreign('role_id')->references('id')->on('project_roles')->cascadeOnDelete();
            $table->foreign(['project_id', 'user_id'])->references(['project_id', 'user_id'])->on('project_members')->cascadeOnDelete();

            // 主キー制約
            $table->primary(['project_id', 'user_id', 'role_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_role_assignments');
    }
};
