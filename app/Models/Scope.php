<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scope extends Model
{
    use HasFactory;

    protected $fillable = [
        'resource',
        'action',
        'name',
        'description',
    ];

    /**
     * このスコープに関連するロールを取得
     */
    public function roles()
    {
        return $this->belongsToMany(ProjectRole::class, 'project_role_scopes', 'scope_id', 'project_role_id');
    }
}
