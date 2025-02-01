<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_invitation_statuses', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->string('display_name');
            $table->text('description')->nullable();
            $table->timestamps();

            // 主キー
            $table->primary('id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_invitation_statuses');
    }
}; 