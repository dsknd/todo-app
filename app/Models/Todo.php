<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'due_date',
        'user_id',
    ];

    // Todo が属するユーザーを取得するリレーションを定義
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 子孫ノードを取得
    public function descendants()
    {
        return $this->belongsToMany(
            self::class,
            'todo_closures',
            'ancestor_id',
            'descendant_id'
        )->withPivot('depth')->orderBy('depth');
    }

    // 祖先ノードを取得
    public function ancestors()
    {
        return $this->belongsToMany(
            self::class,
            'todo_closures',
            'descendant_id',
            'ancestor_id'
        )->withPivot('depth')->orderBy('depth');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_todo');
    }
}