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
        Schema::create('project_member_roles', function (Blueprint $table) {
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('user_id'); // user_idを追加
            $table->unsignedBigInteger('role_id');

            // 外部キー制約
            $table->foreign(['project_id', 'user_id'])
                  ->references(['project_id', 'user_id'])
                  ->on('project_members')
                  ->cascadeOnDelete();

            $table->foreign('role_id')
                  ->references('id')
                  ->on('project_roles')
                  ->cascadeOnDelete();

            // 複合主キー
            $table->primary(['project_id', 'user_id', 'role_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_member_roles');
    }
};