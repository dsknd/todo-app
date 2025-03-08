<?php

namespace App\Repositories;

use App\Models\Project;
use App\Models\ProjectMember;
use App\Repositories\Interfaces\ProjectRepository as ProjectRepositoryInterface;
use App\ValueObjects\ProjectId;
use App\ValueObjects\UserId;
use App\ValueObjects\CategoryId;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class EloquentProjectRepository implements ProjectRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function findById(ProjectId $id): ?Project
    {
        return Project::find($id->getValue());
    }

    /**
     * @inheritDoc
     */
    public function findByIds(array $ids): Collection
    {
        $idValues = array_map(fn(ProjectId $id) => $id->getValue(), $ids);
        return Project::whereIn('id', $idValues)->get();
    }

    /**
     * @inheritDoc
     */
    public function findByUserId(UserId $userId, int $perPage = 15): LengthAwarePaginator
    {
        return Project::where('user_id', $userId->getValue())
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * @inheritDoc
     */
    public function findByMemberId(UserId $userId, int $perPage = 15): LengthAwarePaginator
    {
        return Project::whereHas('members', function ($query) use ($userId) {
                $query->where('user_id', $userId->getValue());
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * @inheritDoc
     */
    public function create(array $attributes): Project
    {
        return Project::create($attributes);
    }

    /**
     * @inheritDoc
     */
    public function update(ProjectId $id, array $attributes): bool
    {
        $project = $this->findById($id);
        
        if (!$project) {
            return false;
        }
        
        return $project->update($attributes);
    }

    /**
     * @inheritDoc
     */
    public function delete(ProjectId $id): bool
    {
        $project = $this->findById($id);
        
        if (!$project) {
            return false;
        }
        
        return $project->delete();
    }

    /**
     * @inheritDoc
     */
    public function canUserAccessProject(UserId $userId, ProjectId $projectId): bool
    {
        $project = $this->findById($projectId);
        
        if (!$project) {
            return false;
        }
        
        // プロジェクトの作成者の場合
        if ($project->user_id == $userId) {
            return true;
        }
        
        // プロジェクトのメンバーの場合
        return $project->members()
            ->where('user_id', $userId)
            ->exists();
    }

    /**
     * @inheritDoc
     */
    public function canUserEditProject(UserId $userId, ProjectId $projectId): bool
    {
        $project = $this->findById($projectId);
        
        if (!$project) {
            return false;
        }
        
        // プロジェクトの作成者の場合
        if ($project->user_id == $userId->getValue()) {
            return true;
        }
        
        // 編集権限を持つロールを持つメンバーの場合
        return $project->members()
            ->where('user_id', $userId->getValue())
            ->whereHas('roles', function ($query) {
                $query->where('can_edit', true);
            })
            ->exists();
    }

    /**
     * @inheritDoc
     */
    public function updateProgress(ProjectId $id): bool
    {
        $project = $this->findById($id);
        
        if (!$project) {
            return false;
        }
        
        $project->updateProgress();
        return true;
    }

    public function addMember(ProjectId $projectId, UserId $userId): bool
    {
        $project = $this->findById($projectId);
        
        if (!$project) {
            return false;
        }
        
        // すでにメンバーの場合は更新
        $existingMember = $project->members()
            ->where('user_id', $userId)
            ->first();
    
        if ($existingMember) {
            return false;
        }
        
        // 新しいメンバーを追加（attach メソッドを使用）
        $project->members()->attach($userId, [
            'joined_at' => now(),
        ]);
        
        return true;
    }

    /**
     * @inheritDoc
     */
    public function removeMember(ProjectId $projectId, UserId $userId): bool
    {
        $project = $this->findById($projectId);
        
        if (!$project) {
            return false;
        }

        $existingMember = $project->members()
            ->where('user_id', $userId)
            ->first();
    
        if (!$existingMember) {
            return false;
        }
        
        $project->members()->detach($userId);

        return true;
    }
}