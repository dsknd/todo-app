<?php

namespace App\Models;

use App\Casts\ProjectRoleTypeIdCast;
use App\Casts\LocaleIdCast;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProjectRoleTypeTranslation extends Pivot
{
    protected $table = 'project_role_type_translations';

    public $timestamps = false;

    protected $fillable = [
        'project_role_type_id',
        'locale_id',
        'name',
        'description',
    ];

    protected $casts = [
        'project_role_type_id' => ProjectRoleTypeIdCast::class,
        'locale_id' => LocaleIdCast::class,
        'name' => 'string',
        'description' => 'string',
    ];
}
