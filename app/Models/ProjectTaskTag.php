<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class ProjectTaskTag extends Tag
{
    /**
     * プロジェクト内のタグを取得
     */
    public static function forProject(int $projectId): Builder
    {
        return static::where('project_id', $projectId);
    }
}
