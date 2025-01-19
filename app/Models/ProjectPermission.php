<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectPermission extends Model
{
    protected $primaryKey = 'permission_id'; // プライマリキーを明示的に指定
    public $incrementing = false;           // 非自動インクリメント
    protected $keyType = 'int';             // プライマリキーのデータ型

    protected $fillable = ['permission_id'];

    /**
     * Permission モデルとの逆リレーション (belongsTo)
     */
    public function permission()
    {
        return $this->belongsTo(Permission::class, 'permission_id');
    }

    /**
     * ProjectPermissionAssignment との1対多（hasMany）。
     */
    public function projectPermissionAssignments()
    {
        return $this->hasMany(ProjectPermissionAssignment::class, 'project_permission_id');
    }
}
