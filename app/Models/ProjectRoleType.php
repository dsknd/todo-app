<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Casts\ProjectRoleTypeIdCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectRoleType extends Model
{
    use HasFactory;

    protected $table = 'project_role_types';

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'key',
    ];

    protected $casts = [
        'id' => ProjectRoleTypeIdCast::class,
        'key' => 'string',
    ];
}
