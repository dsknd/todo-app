<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\ProjectInvitationStatuses;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('project_invitations', function (Blueprint $table) {
            // カラム定義
            $table->id();                                     // ID
            $table->unsignedBigInteger('project_id'); // プロジェクトID
            $table->unsignedBigInteger('inviter_by'); // 招待作成者（ProjectMember）
            $table->unsignedBigInteger('invitee_id'); // 招待されたユーザー（登録済みユーザーの場合）
            // $table->string('invitee_email')->nullable(); // 招待されたメールアドレス（未登録ユーザー）
            $table->string('status')->default(ProjectInvitationStatuses::PENDING->value);
            $table->timestamp('expires_at');                             // 招待の有効期限
            $table->timestamps();

            // 外部キー制約
            $table->foreign('invitee_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();

            $table->foreign(['project_id', 'inviter_by'])
                ->references(['project_id', 'user_id'])
                ->on('project_members')
                ->cascadeOnDelete();

            // インデックス
            $table->index('invitee_id');
            $table->index('status');
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
