<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Casts\PermissionIdCast;
use App\ValueObjects\LocaleId;
use Illuminate\Database\Eloquent\Builder;

class Permission extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'permissions';

    /**
     * The primary key associated with the table.
     * 
     * @var int
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     * 
     * @var array<string>
     */
    protected $fillable = [
        'id',
        'scope',
        'resource',
        'action',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'id' => PermissionIdCast::class,
        'scope' => 'string',
        'resource' => 'string',
        'action' => 'string',
    ];

    /**
     * 権限のクロージャーテーブルを通じた子孫権限との関連
     */
    public function descendants(): BelongsToMany
    {
        return $this->belongsToMany(
            Permission::class,
            'permission_closures',
            'ancestor_id',
            'descendant_id'
        )->withPivot(['depth']);
    }

    /**
     * 権限のクロージャーテーブルを通じた祖先権限との関連
     */
    public function ancestors(): BelongsToMany
    {
        return $this->belongsToMany(
            Permission::class,
            'permission_closures',
            'descendant_id',
            'ancestor_id'
        )->withPivot(['depth']);
    }

    /**
     * プロジェクト権限との関連
     */
    public function projectPermissions(): HasMany
    {
        return $this->hasMany(ProjectPermission::class);
    }

    /**
     * 権限の全階層パスを取得
     * 
     * @return array<Permission> 親権限から順に並んだ配列
     */
    public function getHierarchyPath(): array
    {
        $path = [$this];
        $current = $this;

        while ($current->parentPermission) {
            $current = $current->parentPermission;
            array_unshift($path, $current);
        }

        return $path;
    }

    /**
     * クロージャーテーブルを更新
     */
    public function updateClosure(): void
    {
        // 既存のクロージャーを削除
        \DB::table('permission_closures')
            ->where('descendant_id', $this->id)
            ->delete();

        // 自己参照を追加（深さ0）
        \DB::table('permission_closures')->insert([
            'ancestor_id' => $this->id,
            'descendant_id' => $this->id,
            'depth' => 0,
        ]);

        if ($this->parent_permission_id) {
            // 親の全祖先に対して、このノードへのパスを追加
            $parentClosures = \DB::table('permission_closures')
                ->where('descendant_id', $this->parent_permission_id)
                ->get();

            $newClosures = $parentClosures->map(function ($closure) {
                return [
                    'ancestor_id' => $closure->ancestor_id,
                    'descendant_id' => $this->id,
                    'depth' => $closure->depth + 1,
                ];
            })->all();

            if (!empty($newClosures)) {
                \DB::table('permission_closures')->insert($newClosures);
            }
        }
    }

    /**
     * 指定された権限を含むかどうかを確認
     */
    public function contains(Permission $permission): bool
    {
        return $this->descendants()
            ->where('permissions.id', $permission->id)
            ->exists();
    }

    /**
     * 指定された権限のいずれかに含まれるかどうかを確認
     */
    public function isIncludedIn(array $permissionIds): bool
    {
        return $this->ancestors()
            ->whereIn('permissions.id', $permissionIds)
            ->exists();
    }

    /**
     * 関連する翻訳テーブルを取得
     * 
     * @return array<Permission> 親権限から順に並んだ配列
     */
    public function translations(): HasMany
    {
        return $this->hasMany(PermissionTranslation::class, 'permission_id', 'id');
    }

    /**
     * 翻訳テーブルを含むクエリを返す
     */
    public static function scopeWithTranslations(Builder $query, LocaleId $localeId): Builder
    {
        return $query->with('translations', function ($query) use ($localeId) {
            $query->where('locale_id', $localeId);
        });
    }
    
}
