<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\ProjectInvitation;

class InvitationType extends Model
{
    /**
     * テーブル名
     */
    protected $table = 'invitation_types';

    /**
     * 主キー
     */
    protected $primaryKey = 'id';

    /**
     * 主キーの型
     */
    protected $keyType = 'integer';

    /**
     * タイムスタンプ
     */
    public $timestamps = true;

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
        return $this->hasMany(ProjectInvitation::class, 'invitation_type_id');
    }
}
