<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomTaskCategory extends Model
{
    protected $fillable = [
        'category_id',
        'type_id',
        'project_id',
        'created_by',
    ];
}
