<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Casts\ProjectIdCast;
use App\Casts\UserIdCast;

class Project extends Model
{
    use HasFactory;

    protected $table = 'projects';

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    public $incrementing = true;

    protected $fillable = [
        'name',
        'description',
        'planned_start_date',
        'planned_end_date',
        'actual_start_date',
        'actual_end_date',
        'project_status_id',
        'is_private',
        'user_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'id' => ProjectIdCast::class,
        'planned_start_date' => 'datetime',
        'planned_end_date' => 'datetime',
        'actual_start_date' => 'datetime',
        'actual_end_date' => 'datetime',
        'is_private' => 'boolean',
        'user_id' => UserIdCast::class,
    ];

    /**
     * プロジェクトステータスとの関連
     */
    public function projectStatus(): BelongsTo
    {
        return $this->belongsTo(ProjectStatus::class, 'project_status_id');
    }

    /**
     * 作成者との関連
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * プロジェクトメンバーとの関連
     */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'project_members')
            ->withPivot(['joined_at']);
    }

    /**
     * プロジェクトタスクとの関連
     */
    public function tasks(): BelongsToMany
    {
        return $this->belongsToMany(Task::class, 'project_tasks')
            ->withPivot(['display_order', 'project_wbs_number', 'weight'])
            ->withTimestamps();
    }

    /**
     * プロジェクトマイルストーンとの関連
     */
    public function milestones(): HasMany
    {
        return $this->hasMany(ProjectMilestone::class);
    }

    /**
     * プロジェクトロールとの関連
     */
    public function roles(): HasMany
    {
        return $this->hasMany(ProjectRole::class);
    }

    /**
     * プロジェクト招待との関連
     */
    public function invitations(): HasMany
    {
        return $this->hasMany(ProjectInvitation::class);
    }

    /**
     * プロジェクトの進捗率を計算して更新
     */
    public function updateProgress(): void
    {
        $this->progress = $this->tasks()
            ->withPivot('weight')
            ->get()
            ->average(fn ($task) => $task->progress * $task->pivot->weight) ?? 0;
        
        $this->save();
    }

    /**
     * プロジェクトの開始日を取得（計画または実績）
     */
    public function getStartDate(): ?\DateTime
    {
        return $this->actual_start_date ?? $this->planned_start_date;
    }

    /**
     * プロジェクトの終了日を取得（計画または実績）
     */
    public function getEndDate(): ?\DateTime
    {
        return $this->actual_end_date ?? $this->planned_end_date;
    }

    /**
     * プロジェクトが遅延しているかどうかを判定
     */
    public function isDelayed(): bool
    {
        if (!$this->planned_end_date) {
            return false;
        }

        if ($this->actual_end_date) {
            return $this->actual_end_date > $this->planned_end_date;
        }

        return now() > $this->planned_end_date;
    }

    /**
     * プロジェクトの全階層パスを取得
     * 
     * @return array<Project> 親プロジェクトから順に並んだ配列
     */
    public function getHierarchyPath(): array
    {
        $path = [$this];
        $current = $this;

        while ($current->parentProject) {
            $current = $current->parentProject;
            array_unshift($path, $current);
        }

        return $path;
    }
}
