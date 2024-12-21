<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\ProjectType;
use App\Models\User;


class ProjectController extends Controller
{
    public function index()
    {
        return response()->json(Project::with('type')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'project_type_id' => 'nullable|exists:project_types,id',
        ]);

        // project_type_id が指定されていない場合、is_primitive の最初のレコードを取得
        if (empty($validated['project_type_id'])) {
            $primitiveProjectType = ProjectType::where('is_primitive', true)
                ->where('user_id', auth()->id())
                ->first();

            if (!$primitiveProjectType) {
                return response()->json(['error' => 'No primitive project type found.'], 400);
            }

            $validated['project_type_id'] = $primitiveProjectType->id;
        }

        // プロジェクトを作成
        $project = Project::create($validated);

        return response()->json($project, 201);
    }

    public function show(Project $project)
    {
        return response()->json($project->load('type'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'project_type_id' => 'required|exists:project_types,id',
        ]);

        $project->update($validated);

        return response()->json($project);
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}