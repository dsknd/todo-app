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
        Schema::create('project_roles', function (Blueprint $table) { // `$table` をコールバック引数として明示
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete(); // プロジェクト
            $table->string('name'); // ロール名
            $table->string('description')->nullable(); // ロールの説明
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_roles');
    }
};