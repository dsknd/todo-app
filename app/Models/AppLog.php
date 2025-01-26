<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class AppLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'loggable_type',
        'loggable_id',
        'description',
        'details',
        'ip_address',
        'user_agent',
        'severity',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'details' => 'array',
    ];

    /**
     * ログの重要度定義
     */
    public const SEVERITY_INFO = 'info';
    public const SEVERITY_WARNING = 'warning';
    public const SEVERITY_ERROR = 'error';
    public const SEVERITY_CRITICAL = 'critical';

    /**
     * 実行ユーザーとの関連
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * ログ対象のモデルとの関連（ポリモーフィック）
     */
    public function loggable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * ログエントリを作成
     */
    public static function createEntry(
        string $action,
        Model $loggable,
        ?User $user = null,
        ?string $description = null,
        array $details = [],
        string $severity = self::SEVERITY_INFO
    ): self {
        return static::create([
            'user_id' => $user?->id,
            'action' => $action,
            'loggable_type' => get_class($loggable),
            'loggable_id' => $loggable->id,
            'description' => $description,
            'details' => $details,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'severity' => $severity,
        ]);
    }

    /**
     * エラーログエントリを作成
     */
    public static function createErrorEntry(
        string $action,
        Model $loggable,
        string $description,
        array $details = [],
        string $severity = self::SEVERITY_ERROR
    ): self {
        return static::createEntry(
            action: $action,
            loggable: $loggable,
            description: $description,
            details: $details,
            severity: $severity
        );
    }

    /**
     * プロジェクト関連のログを取得
     */
    public static function getProjectLogs(int $projectId): array
    {
        return static::where('loggable_type', Project::class)
            ->where('loggable_id', $projectId)
            ->orWhereHas('loggable', function ($query) use ($projectId) {
                $query->where('project_id', $projectId);
            })
            ->orderByDesc('created_at')
            ->get()
            ->all();
    }

    /**
     * ユーザーのアクションログを取得
     */
    public static function getUserLogs(int $userId): array
    {
        return static::where('user_id', $userId)
            ->orderByDesc('created_at')
            ->get()
            ->all();
    }

    /**
     * エラーログを取得
     */
    public static function getErrorLogs(): array
    {
        return static::whereIn('severity', [self::SEVERITY_ERROR, self::SEVERITY_CRITICAL])
            ->orderByDesc('created_at')
            ->get()
            ->all();
    }

    /**
     * 重要度でログをフィルタリング
     */
    public static function getBySeverity(string $severity): array
    {
        return static::where('severity', $severity)
            ->orderByDesc('created_at')
            ->get()
            ->all();
    }

    /**
     * アクションでログをフィルタリング
     */
    public static function getByAction(string $action): array
    {
        return static::where('action', $action)
            ->orderByDesc('created_at')
            ->get()
            ->all();
    }

    /**
     * 期間でログをフィルタリング
     */
    public static function getByDateRange(string $startDate, string $endDate): array
    {
        return static::whereBetween('created_at', [$startDate, $endDate])
            ->orderByDesc('created_at')
            ->get()
            ->all();
    }

    /**
     * IPアドレスでログをフィルタリング
     */
    public static function getByIpAddress(string $ipAddress): array
    {
        return static::where('ip_address', $ipAddress)
            ->orderByDesc('created_at')
            ->get()
            ->all();
    }
}
