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
        Schema::create('scopes', function (Blueprint $table) {
            $table->id();
            $table->string('resource'); // リソース名
            $table->string('action'); // アクション名
            $table->string('name'); // スコープの名前
            $table->string('description')->nullable(); // スコープの説明
            $table->timestamps();

            // リソースとアクションの組み合わせをユニークにする
            $table->unique(['resource', 'action'], 'unique_resource_action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scopes');
    }
};