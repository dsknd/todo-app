<?php

namespace App\Repositories;

use App\Models\Project;
use App\Repositories\Interfaces\ProjectRepository as ProjectRepositoryInterface;
use App\ValueObjects\ProjectId;
use App\ValueObjects\UserId;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection as SupportCollection;

class EloquentProjectRepository implements ProjectRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function findById(ProjectId $projectId): ?Project
    {
        return Project::query()->find($projectId->getValue());
    }

    /**
     * @inheritDoc
     */
    public function findByIds(array $projectIds): Collection
    {
        $projectIdValues = array_map(fn(ProjectId $projectId) => $projectId, $projectIds);
        return Project::whereIn('id', $projectIdValues)->get();
    }

    /**
     * @inheritDoc
     */
    public function findByUserId(UserId $userId, int $perPage = 15): LengthAwarePaginator
    {
        return Project::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * @inheritDoc
     */
    public function findByMemberId(UserId $userId, int $perPage = 15): LengthAwarePaginator
    {
        return Project::whereHas('members', function ($query) use ($userId) {
                $query->where('user_id', $userId);
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
    public function update(ProjectId $projectId, array $attributes): bool
    {
        $project = $this->findById($projectId);
        
        if (!$project) {
            return false;
        }
        
        return $project->update($attributes);
    }

    /**
     * @inheritDoc
     */
    public function delete(ProjectId $projectId): bool
    {
        $project = $this->findById($projectId);
        
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

    /**
     * 参加者IDによってプロジェクトを検索します
     *
     * @param UserId $userId
     * @return Collection<int, Project>
     */
    public function findByParticipantId(UserId $userId): SupportCollection
    {
        return Project::query()
            ->whereHas('members', function ($query) use ($userId) {
                $query->where('user_id', $userId->getValue());
            })
            ->orWhere('user_id', $userId->getValue()) // プロジェクト作成者も含める
            ->get();
    }
}