<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\InvitationStatusEnum;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('project_invitations', function (Blueprint $table) {
            // カラム定義
            $table->id()->comment('ID');
            $table->unsignedBigInteger('project_id')->comment('プロジェクトID'); 
            $table->unsignedBigInteger('inviter_by')->comment('招待作成者（ProjectMember）'); 
            $table->unsignedBigInteger('invitation_status_id')->default(InvitationStatusEnum::PENDING->value);
            $table->unsignedBigInteger('invitation_type_id');
            $table->timestamp('expires_at')->comment('招待の有効期限');
            $table->timestamps();

            // 外部キー制約
            $table->foreign(['project_id', 'inviter_by'])
                ->references(['project_id', 'user_id'])
                ->on('project_members')
                ->cascadeOnDelete();

            $table->foreign('invitation_status_id')
                ->references('id')
                ->on('invitation_statuses')
                ->cascadeOnDelete();

            $table->foreign('invitation_type_id')
                ->references('id')
                ->on('invitation_types')
                ->cascadeOnDelete();

            // インデックス
            $table->index('invitation_status_id');
            $table->index('invitation_type_id');
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
