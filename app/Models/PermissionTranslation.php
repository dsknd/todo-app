<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Casts\PermissionIdCast;
use App\Casts\LocaleIdCast;

class PermissionTranslation extends Pivot
{
    protected $table = 'permission_translations';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';
    public $incrementing = false;

    protected $fillable = [
        'permission_id',
        'locale_id',
        'name',
        'description',
    ];

    protected $casts = [
        'permission_id' => PermissionIdCast::class,
        'locale_id' => LocaleIdCast::class,
        'name' => 'string',
        'description' => 'string',
    ];
    
    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }
}
