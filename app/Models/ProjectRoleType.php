<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Casts\ProjectRoleTypeIdCast;
class ProjectRoleType extends Model
{
    protected $table = 'project_role_types';

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'key',
    ];

    protected $casts = [
        'id' => ProjectRoleTypeIdCast::class,
        'key' => 'string',
    ];
}
