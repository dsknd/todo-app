<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\InvitationStatusEnum;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\InvitationType;
use App\Models\InvitationStatus;

class ProjectInvitation extends Model
{
    /**
     * 複数代入可能な属性
     *
     * @var array<string>
     */
    protected $fillable = [
        'project_id',
        'invitation_type_id',
        'invitation_status_id',
        'expires_at',
    ];

    /**
     * 属性のキャスト
     *
     * @var array<string, string>
     */
    protected $casts = [
        'project_id' => 'integer',
        'invitation_type_id' => 'integer',
        'invitation_status_id' => 'integer',
        'expires_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * プロジェクトを取得
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * 招待タイプを取得
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(InvitationType::class, 'invitation_type_id');
    }

    /**
     * 招待ステータスを取得
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(InvitationStatus::class, 'invitation_status_id');
    }

    /**
     * メール招待の詳細を取得
     */
    public function emailInvitation(): HasOne
    {
        return $this->hasOne(ProjectEmailInvitation::class);
    }

    /**
     * ユーザー招待の詳細を取得
     */
    public function userInvitation(): HasOne
    {
        return $this->hasOne(ProjectUserInvitation::class);
    }

    /**
     * 招待が有効期限切れかどうかを確認
     */
    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    /**
     * 招待を承諾
     */
    public function accept(): void
    {
        $this->updateStatus(InvitationStatusEnum::ACCEPTED);
    }

    /**
     * 招待を辞退
     */
    public function decline(): void
    {
        $this->updateStatus(InvitationStatusEnum::DECLINED);
    }

    /**
     * 招待をキャンセル
     */
    public function cancel(): void
    {
        $this->updateStatus(InvitationStatusEnum::CANCELED);
    }
}
