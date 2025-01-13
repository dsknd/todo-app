<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OwnershipType extends Model
{
    protected $table = 'ownership_types';

    protected $keyType = 'int';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
        'description'
    ];
}
