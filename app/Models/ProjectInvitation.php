<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectInvitation extends Model
{
    //
    protected $fillable = [
        'project_id',
        'invited_by',
        'invitee_id',
        'status_id',
        'expires_at',
    ];
}
