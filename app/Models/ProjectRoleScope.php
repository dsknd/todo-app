<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProjectRoleScope extends Pivot
{
    protected $table = 'project_role_scopes';
    public $incrementing = false; // 自動インクリメントを無効化
    protected $primaryKey = ['project_role_id', 'scope_id']; // 複合主キー
}