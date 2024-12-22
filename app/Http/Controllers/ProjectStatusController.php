<?php

namespace App\Http\Controllers;

use App\Models\ProjectStatus;
use Illuminate\Http\Request;

class ProjectStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $statuses = ProjectStatus::all();
        return response()->json($statuses, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:project_statuses,name|max:255',
            'description' => 'nullable|string|max:500',
            'color' => 'nullable|string|regex:/^#[a-fA-F0-9]{6}$/',
        ]);

        $status = ProjectStatus::create($validated);

        return response()->json([
            'message' => 'Project status created successfully',
            'status' => $status,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(ProjectStatus $projectStatus)
    {
        return response()->json($projectStatus, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProjectStatus $projectStatus)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:project_statuses,name,' . $projectStatus->id . '|max:255',
            'description' => 'nullable|string|max:500',
            'color' => 'nullable|string|regex:/^#[a-fA-F0-9]{6}$/',
        ]);

        $projectStatus->update($validated);

        return response()->json([
            'message' => 'Project status updated successfully',
            'status' => $projectStatus,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectStatus $projectStatus)
    {
        $projectStatus->delete();

        return response()->json(['message' => 'Project status deleted successfully'], 200);
    }
}