<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_invitation_types', function (Blueprint $table) {
            // カラム定義
            $table->id()->comment('ID');
            $table->string('display_name')->comment('表示名');
            $table->text('description')->nullable()->comment('説明');
            $table->timestamps();

            // 主キー
            $table->primary('id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_invitation_types');
    }
}; 