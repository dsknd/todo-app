<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Todo;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'user_id'];

    // カテゴリが属するユーザー
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // カテゴリに紐付くTodo
    public function todos()
    {
        return $this->belongsToMany(Todo::class, 'category_todo');
    }
}
