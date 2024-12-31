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
        Schema::create('project_role_scopes', function (Blueprint $table) {
            $table->foreignId('role_id')->constrained('project_roles')->cascadeOnDelete(); // ロール
            $table->foreignId('scope_id')->constrained('scopes')->cascadeOnDelete(); // スコープ
            $table->timestamps();

            // 複合主キーを設定
            $table->primary(['role_id', 'scope_id'], 'project_role_scope_primary');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_role_scopes');
    }
};