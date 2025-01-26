<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    protected $fillable = [
        'name',
        'description',
        'parent_category_id',
    ];

    /**
     * 親カテゴリーとの関連
     */
    public function parentCategory(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_category_id');
    }

    /**
     * 子カテゴリーとの関連
     */
    public function childCategories(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_category_id');
    }

    /**
     * このカテゴリーに属するプロジェクトとの関連
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    /**
     * カテゴリーの全階層パスを取得
     * 
     * @return array<Category> 親カテゴリーから順に並んだ配列
     */
    public function getHierarchyPath(): array
    {
        $path = [$this];
        $current = $this;

        while ($current->parentCategory) {
            $current = $current->parentCategory;
            array_unshift($path, $current);
        }

        return $path;
    }
}