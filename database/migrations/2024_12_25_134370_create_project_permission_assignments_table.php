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
        Schema::create('project_permission_assignments', function (Blueprint $table) {
            // カラム定義
            $table->unsignedBigInteger('project_permission_id');
            $table->unsignedBigInteger('project_role_id');
            $table->timestamp('assigned_at')->useCurrent();

            // 外部キー制約
            $table->foreign('project_permission_id', 'fk_project_permission_assignments_permission_id')
                ->references('permission_id')
                ->on('project_permissions')
                ->cascadeOnDelete();

            $table->foreign('project_role_id', 'fk_project_permission_assignments_role_id')
                ->references('id')
                ->on('project_roles')
                ->cascadeOnDelete();

            // 主キー定義
            $table->primary(['project_role_id', 'project_permission_id']);

            // インデックス定義
            $table->index('project_permission_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_permission_assignments');
    }
};
