<?php

namespace App\Models;

use App\Enums\ProjectInvitationStatuses;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectInvitation extends Model
{
    protected $fillable = [
        'project_id',
        'inviter_by',
        'invitee_id',
        'status',
        'expires_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => ProjectInvitationStatuses::class,
        'expires_at' => 'datetime',
    ];

    /**
     * 関連するプロジェクトを取得
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * 招待者を取得
     */
    public function inviter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'inviter_by');
    }

    /**
     * 被招待者を取得
     */
    public function invitee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'invitee_id');
    }

    /**
     * 招待が有効期限切れかどうかを確認
     */
    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    /**
     * 招待のステータスを変更
     * 
     * @throws \InvalidArgumentException ステータスの遷移が不正な場合
     */
    public function updateStatus(ProjectInvitationStatuses $newStatus): void
    {
        if (!$this->status->canTransitionTo($newStatus)) {
            throw new \InvalidArgumentException("Cannot transition from {$this->status->value} to {$newStatus->value}");
        }

        $this->status = $newStatus;
        $this->save();
    }

    /**
     * 招待を承諾
     */
    public function accept(): void
    {
        $this->updateStatus(ProjectInvitationStatuses::ACCEPTED);
    }

    /**
     * 招待を辞退
     */
    public function decline(): void
    {
        $this->updateStatus(ProjectInvitationStatuses::DECLINED);
    }

    /**
     * 招待をキャンセル
     */
    public function cancel(): void
    {
        $this->updateStatus(ProjectInvitationStatuses::CANCELED);
    }
}
