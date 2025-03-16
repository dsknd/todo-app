<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PermissionClosure extends Pivot
{
    use HasFactory;

    protected $table = 'permission_closures';
    public $timestamps = false;

    protected $fillable = [
        'ancestor_id',
        'descendant_id',
        'depth',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'depth' => 'integer',
    ];

    /**
     * 祖先権限との関連
     */
    public function ancestor(): BelongsTo
    {
        return $this->belongsTo(Permission::class, 'ancestor_id');
    }

    /**
     * 子孫権限との関連
     */
    public function descendant(): BelongsTo
    {
        return $this->belongsTo(Permission::class, 'descendant_id');
    }

    /**
     * 指定された権限の全祖先を取得
     * 
     * @param int $permissionId 権限ID
     * @return array<Permission> 祖先権限の配列（深さでソート）
     */
    public static function getAncestors(int $permissionId): array
    {
        return static::where('descendant_id', $permissionId)
            ->where('depth', '>', 0)
            ->orderBy('depth')
            ->with('ancestor')
            ->get()
            ->map(fn ($closure) => $closure->ancestor)
            ->all();
    }

    /**
     * 指定された権限の全子孫を取得
     * 
     * @param int $permissionId 権限ID
     * @return array<Permission> 子孫権限の配列（深さでソート）
     */
    public static function getDescendants(int $permissionId): array
    {
        return static::where('ancestor_id', $permissionId)
            ->where('depth', '>', 0)
            ->orderBy('depth')
            ->with('descendant')
            ->get()
            ->map(fn ($closure) => $closure->descendant)
            ->all();
    }

    /**
     * 指定された権限の直接の子を取得
     * 
     * @param int $permissionId 権限ID
     * @return array<Permission> 子権限の配列
     */
    public static function getChildren(int $permissionId): array
    {
        return static::where('ancestor_id', $permissionId)
            ->where('depth', 1)
            ->with('descendant')
            ->get()
            ->map(fn ($closure) => $closure->descendant)
            ->all();
    }

    /**
     * 指定された権限の直接の親を取得
     */
    public static function getParent(int $permissionId): ?Permission
    {
        $closure = static::where('descendant_id', $permissionId)
            ->where('depth', 1)
            ->with('ancestor')
            ->first();

        return $closure ? $closure->ancestor : null;
    }
}
