<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\ProjectInvitation;

class InvitationStatus extends Model
{
    /**
     * 複数代入可能な属性
     *
     * @var array<string>
     */
    protected $fillable = [
        'id',
        'key',
    ];

    /**
     * 属性のキャスト
     *
     * @var array<string, string>
     */
    protected $casts = [
        'id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * このステータスを持つプロジェクト招待一覧を取得
     */
    public function projectInvitations(): HasMany
    {
        return $this->hasMany(ProjectInvitation::class, 'status_id');
    }
}
