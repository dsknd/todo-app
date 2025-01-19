<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectRoleAssignment;
use App\Models\User;
use App\Models\ProjectRole;
use Illuminate\Http\Response;
use App\Models\ProjectMember;

class ProjectRoleAssignmentController extends Controller
{
    public function attach(Project $project, User $user, ProjectRole $projectRole){
        // TODO: ポリシー

        // プロジェクトメンバの確認
        $projectMember = ProjectMember::where('project_id', $project->id)
            ->where('user_id', $user->id)
            ->first();
    
        if (!$projectMember) {
            return response()->json(['error' => 'User is not a member of the project'], Response::HTTP_BAD_REQUEST);
        }

        ProjectRoleAssignment::updateOrCreate([
            'project_id' => $project->id,
            'user_id' => $user->id,
            'project_role_id' => $projectRole->id,
        ]);

        // レスポンス
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    public function detach(Project $project, User $user, ProjectRole $role)
    {
        ProjectRoleAssignment::where([
            'project_id' => $project->id,
            'user_id' => $user->id,
            'project_role_id' => $role->id,
        ])->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
