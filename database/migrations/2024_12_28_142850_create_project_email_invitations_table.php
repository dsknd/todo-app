<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_email_invitations', function (Blueprint $table) {
            // カラム定義
            $table->foreignId('project_invitation_id')->comment('プロジェクト招待ID')->cascadeOnDelete();
            $table->string('email')->comment('メールアドレス');
            $table->string('token')->unique()->comment('トークン');
            $table->timestamps();

            // 外部キー制約
            $table->foreign('project_invitation_id')
                ->references('id')
                ->on('project_invitations')
                ->cascadeOnDelete();

            // 主キー
            $table->primary('project_invitation_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_email_invitations');
    }
}; 