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
            $table->unsignedBigInteger('project_id');         // プロジェクトID
            $table->unsignedBigInteger('project_role_id');    // プロジェクトロールID
            $table->unsignedBigInteger('assignee_id');   // 割当たられたユーザーID
            $table->unsignedBigInteger('assigner_id');   // 割り当てたユーザID
            $table->timestamp('assigned_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            // 外部キー定義
            $table->foreign('project_role_id', 'fk_project_role_assignments_role_id')
                ->references('id')
                ->on('project_roles')
                ->cascadeOnDelete();

            $table->foreign(['project_id', 'assignee_id'])
                ->references(['project_id', 'user_id'])
                ->on('project_members')
                ->cascadeOnDelete();

            $table->foreign('assigner_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();

            // 主キー定義
            $table->primary(['project_id', 'assignee_id', 'project_role_id']);

            // インデックス定義
            $table->index(['project_id', 'project_role_id']);
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
