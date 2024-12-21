<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodoClosure extends Model
{
    use HasFactory;

    protected $table = 'todo_closures';

    protected $fillable = [
        'ancestor_id',
        'descendant_id',
        'depth',
    ];

    // 祖先の Todo
    public function ancestor()
    {
        return $this->belongsTo(Todo::class, 'ancestor_id');
    }

    // 子孫の Todo
    public function descendant()
    {
        return $this->belongsTo(Todo::class, 'descendant_id');
    }
}