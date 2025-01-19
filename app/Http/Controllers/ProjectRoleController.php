<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectRole;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use App\Enums\ProjectRoleTypes;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use App\Models\ProjectPermission;
use App\Http\Resources\PermissionResource;
use App\Http\Requests\StoreProjectRoleRequest;
use App\Http\Requests\UpdateProjectRoleRequest;

class ProjectRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //プロジェクトロールの権限を取得
        $permissions = ProjectPermission::with([
            'permission.descendants' => function ($query) {
                $query->whereColumn('id', '<>', 'ancestor_id') 
                      ->select('id', 'scope', 'display_name', 'description');
            }
        ])->select('permission_id')->get();

        return response()->json(
            PermissionResource::collection($permissions->pluck('permission')),
            Response::HTTP_OK
        );
    }

    /**
     * プロジェクトロールを作成します。
     */
    public function store(StoreProjectRoleRequest $request)
    {
        // プロジェクトを取得
        $projectId = $request->input('project_id');
        $project = Project::findOrFail($projectId);

        // ポリシーを使用してプロジェクトロールの作成権限を確認
        $this->authorize('create', [ProjectRole::class, $project]);

        // プロジェクトロールを作成
        $projectRole = ProjectRole::create([
            'project_role_type_id' => ProjectRoleTypes::CUSTOM,
            'project_id' => $projectId,
            'created_by' => Auth::user()->id,
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        return response()->json($projectRole, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(ProjectRole $projectRole)
    {
        // ポリシーを使用してプロジェクトロールの表示権限を確認
        $this->authorize('view', $projectRole);

        return response()->json($projectRole, Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProjectRole $projectRole)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRoleRequest $request, string $id)
    {
        // TODO: ポリシーを使用してプロジェクトロールの編集権限を確認

        // validate
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $id) {
            $projectRole = ProjectRole::findOrFail($id);
            $projectRole->update($request->all());
        });

        return response()->json(['message' => 'Project role updated successfully'], Response::HTTP_OK);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
