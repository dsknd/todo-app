<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectMember;
use App\Models\Project;
use App\Models\User;

class ProjectMemberController extends Controller
{
    public function index(Project $project)
    {
        return $project->members;
    }

    public function store(Project $project, Request $request)
    {
        $project->members()->attach($request->user_id);
        return response()->json(['message' => 'Member added to project']);
    }

    public function destroy(Project $project, User $user)
    {
        $project->members()->detach($user->id);
        return response()->json(['message' => 'Member removed from project']);
    }

    public function update(Project $project, User $user, Request $request)
    {
        $project->members()->updateExistingPivot($user->id, $request->all());
        return response()->json(['message' => 'Member updated']);
    }
}
