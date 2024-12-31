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
        Schema::create('project_invitations', function (Blueprint $table) {
            $table->unsignedBigInteger('project_id'); // プロジェクトID
            $table->unsignedBigInteger('invited_by'); // 招待作成者（ProjectMember）
            $table->unsignedBigInteger('invitee_id'); // 招待されたユーザー（登録済みユーザーの場合）
            // $table->string('invitee_email')->nullable(); // 招待されたメールアドレス（未登録ユーザー）
            $table->unsignedBigInteger('status_id'); // 招待ステータスID
            $table->timestamp('expires_at'); // 招待の有効期限
            $table->timestamps();

            // 外部キー制約
            $table->foreign('status_id')->references('id')->on('project_invitation_statuses')->cascadeOnDelete();
            $table->foreign('invitee_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign(['project_id', 'invited_by'])
            ->references(['project_id', 'user_id'])
            ->on('project_members')
            ->cascadeOnDelete();

            $table->primary(['project_id', 'invited_by', 'invitee_id', 'expires_at']);

            $table->index('invitee_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_invitations');
    }
};