<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Enums\ProjectInvitationTypeEnum;

class ProjectInvitationType extends Model
{
    protected $primaryKey = 'id';
    protected $keyType = 'integer';

    protected $fillable = [
        'id',
        'display_name',
        'description',
    ];

    protected $casts = [
        'id' => ProjectInvitationTypeEnum::class,
    ];

    public function projectInvitations(): HasMany
    {
        return $this->hasMany(ProjectInvitation::class);
    }
} 