<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectRoleType extends Model
{
    protected $table = 'project_role_types';

    protected $keyType = 'int';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
        'description',
    ];
}
