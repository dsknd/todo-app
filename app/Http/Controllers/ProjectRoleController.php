<?php

namespace App\Http\Controllers;

use App\Enums\ProjectRoleTypes;
use App\Http\Requests\StoreProjectRoleRequest;
use App\Http\Requests\UpdateProjectRoleRequest;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\ProjectRoleResource;
use App\Models\AppLog;
use App\Models\Project;
use App\Models\ProjectPermission;
use App\Models\ProjectRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class ProjectRoleController extends Controller
{
    /**
     * プロジェクトロールの一覧を取得
     */
    public function index(Project $project)
    {
        $roles = ProjectRole::where('project_id', $project->id)
            ->with(['projectPermissions', 'creator'])
            ->get();

        return response()->json(
            ProjectRoleResource::collection($roles),
            Response::HTTP_OK
        );
    }

    /**
     * プロジェクトロール作成用の権限一覧を取得
     */
    public function create(Project $project)
    {
        $permissions = ProjectPermission::with([
            'permission.descendants' => function ($query) {
                $query->whereColumn('id', '<>', 'ancestor_id')
                    ->select('id', 'name', 'description');
            }
        ])->select('id', 'permission_id', 'name', 'description')
          ->orderBy('name')
          ->get();

        return response()->json(
            PermissionResource::collection($permissions),
            Response::HTTP_OK
        );
    }

    /**
     * プロジェクトロールを作成
     */
    public function store(StoreProjectRoleRequest $request, Project $project)
    {
        // プロジェクトロールを作成
        try {
            $projectRole = ProjectRole::create([
                'project_id' => $project->id,
                'user_id' => Auth::id(),
                'name' => $request->input('name'),
                'description' => $request->input('description'),
            ]);
        } catch (\Exception $e) {
            return response()->json(
                ['message' => 'Failed to create project role: ' . $e->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return response()->json(
            new ProjectRoleResource($projectRole->load('projectPermissions')),
            Response::HTTP_CREATED
        );
    }

    /**
     * プロジェクトロールの詳細を取得
     */
    public function show(Project $project, ProjectRole $projectRole)
    {
        return response()->json(
            new ProjectRoleResource($projectRole->load(['projectPermissions', 'creator'])),
            Response::HTTP_OK
        );
    }

    /**
     * プロジェクトロールを更新
     */
    public function update(UpdateProjectRoleRequest $request, Project $project, ProjectRole $projectRole)
    {
        // デフォルトロールは編集不可
        if ($projectRole->project_role_type_id === ProjectRoleTypes::DEFAULT) {
            return response()->json(
                ['message' => 'Cannot modify default project role'],
                Response::HTTP_FORBIDDEN
            );
        }

        $updatedRole = DB::transaction(function () use ($request, $projectRole) {
            // 基本情報を更新
            $projectRole->update([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
            ]);

            // 権限を更新
            if ($request->has('permissions')) {
                $projectRole->projectPermissions()->sync($request->input('permissions'));
            }

            // ログを記録
            AppLog::createEntry(
                'update',
                $projectRole,
                Auth::user(),
                'Updated project role',
                [
                    'role_name' => $projectRole->name,
                    'changes' => $projectRole->getChanges(),
                ]
            );

            return $projectRole;
        });

        return response()->json(
            new ProjectRoleResource($updatedRole->load('projectPermissions')),
            Response::HTTP_OK
        );
    }

    /**
     * プロジェクトロールを削除
     */
    public function destroy(Project $project, ProjectRole $projectRole)
    {
        // デフォルトロールは削除不可
        if ($projectRole->project_role_type_id === ProjectRoleTypes::DEFAULT) {
            return response()->json(
                ['message' => 'Cannot delete default project role'],
                Response::HTTP_FORBIDDEN
            );
        }

        DB::transaction(function () use ($projectRole) {
            // ログを記録
            AppLog::createEntry(
                'delete',
                $projectRole,
                Auth::user(),
                'Deleted project role',
                ['role_name' => $projectRole->name]
            );

            $projectRole->delete();
        });

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * プロジェクトロールに権限を割り当て
     */
    public function assignPermissions(Request $request, Project $project, ProjectRole $projectRole)
    {
        $this->authorize('update', $projectRole);

        $validated = $request->validate([
            'permissions' => 'required|array',
            'permissions.*' => 'exists:project_permissions,id',
        ]);

        DB::transaction(function () use ($projectRole, $validated) {
            $projectRole->projectPermissions()->sync($validated['permissions']);

            // ログを記録
            AppLog::createEntry(
                'assign_permissions',
                $projectRole,
                Auth::user(),
                'Assigned permissions to project role',
                [
                    'role_name' => $projectRole->name,
                    'permissions' => $validated['permissions'],
                ]
            );
        });

        return response()->json(
            new ProjectRoleResource($projectRole->load('projectPermissions')),
            Response::HTTP_OK
        );
    }
}
