<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permissions';

    protected $keyType = 'int';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'scope',
        'resource',
        'action',
        'display_name',
        'description',
    ];

    public function descendants()
    {
        return $this->hasManyThrough(
            Permission::class,      // 子モデル（最終的に取得したいモデル）
            PermissionClosure::class, // 中間テーブル（閉包テーブル）
            'ancestor_id',          // 中間テーブル内のこのモデルの外部キー
            'id',                   // 子モデルのキー
            'id',                   // 現在のモデルのキー
            'descendant_id'         // 中間テーブルの子モデルの外部キー
        );
    }

    /**
     * 祖先権限を取得 (閉包テーブルを直接利用)
     */
    public function ancestors()
    {
        return $this->hasMany(PermissionClosure::class, 'descendant_id', 'id');
    }

    /**
     * ProjectPermission との1対1（hasOne）。
     * ※ project_permissions.permission_id = permissions.id
     */
    public function projectPermission()
    {
        return $this->hasOne(ProjectPermission::class, 'permission_id');
    }
}
