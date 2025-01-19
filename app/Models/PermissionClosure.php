<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PermissionClosure extends Pivot
{
    protected $table = 'permission_closures';

    protected $fillable = [
        'permission_id',
        'parent_id',
        'depth',
    ];

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }
}
