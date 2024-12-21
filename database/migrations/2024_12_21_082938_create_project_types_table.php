<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('project_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->boolean('is_primitive')->default(false);
            $table->boolean('is_default')->default(false); 
            $table->boolean('is_default_unique')->virtualAs('IF(is_default, 1, NULL)');
            $table->timestamps();
        
            $table->unique(['user_id', 'is_default_unique']); // 条件付きのユニーク制約
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_types');
    }
};