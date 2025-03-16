<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectEmailInvitation extends Model
{
    /**
     * プライマリーキーの設定
     */
    protected $primaryKey = 'project_invitation_id';
    public $incrementing = false;

    /**
     * 複数代入可能な属性
     *
     * @var array<string>
     */
    protected $fillable = [
        'project_invitation_id',
        'email',
        'token',
    ];

    /**
     * 属性のキャスト
     *
     * @var array<string, string>
     */
    protected $casts = [
        'project_invitation_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * 親の招待を取得
     */
    public function projectInvitation(): BelongsTo
    {
        return $this->belongsTo(ProjectInvitation::class);
    }
} 