<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;

class ProjectController
{
    /**
     * Display a listing of the projects.
     */
    public function index()
    {
        $projects = Auth::user()->projects;
        return response()->json($projects, 200);
    }

    /**
     * Store a newly created project in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'status_id' => 'nullable|exists:project_statuses,id',
            'progress' => 'nullable|integer|min:0|max:100',
        ]);

        // デフォルト値を設定
        $validated['owner_id'] = Auth::id();

        $project = Project::create($validated);

        return response()->json([
            'message' => 'Project created successfully',
            'project' => $project,
        ], 201);
    }

    /**
     * Display the specified project.
     */
    public function show(Project $project)
    {
        $this->authorize('view', $project);

        return response()->json($project, 200);
    }

    /**
     * Update the specified project in storage.
     */
    public function update(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'status' => 'nullable|exists:project_statuses,id',
            'progress' => 'nullable|integer|min:0|max:100',
        ]);

        $project->update($validated);

        return response()->json([
            'message' => 'Project updated successfully',
            'project' => $project,
        ], 200);
    }

    /**
     * Remove the specified project from storage.
     */
    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);

        $project->delete();

        return response()->json([
            'message' => 'Project deleted successfully',
        ], 200);
    }

    public function addMember(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        // 中間テーブルにメンバーを追加
        $project->members()->attach($validated['user_id']);

        return response()->json(['message' => 'Member added successfully'], 200);
    }

    public function removeMember(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        // 中間テーブルからメンバーを削除
        $project->members()->detach($validated['user_id']);

        return response()->json(['message' => 'Member removed successfully'], 200);
    }
}
