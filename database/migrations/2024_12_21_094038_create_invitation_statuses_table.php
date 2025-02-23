<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invitation_statuses', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->string('key');
            $table->timestamps();

            // 主キー
            $table->primary('id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invitation_statuses');
    }
}; 