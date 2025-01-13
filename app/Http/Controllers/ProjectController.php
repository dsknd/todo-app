<?php

namespace App\Http\Controllers;

use App\Enums\Categories;
use App\Enums\ProjectInvitationStatuses;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use Symfony\Component\HttpFoundation\Response;
use App\Enums\ProjectStatus;
use Illuminate\Support\Facades\DB;
use App\Enums\ProjectPermissions;
use App\Enums\ProjectStatuses;
use App\Enums\ProjectRoleTypes;
use App\Models\ProjectPermission;
use App\Models\ProjectRole;

class ProjectController extends Controller
{
    /**
     * @group プロジェクト管理
     *
     * プロジェクト一覧を取得します。
     *
     * @queryParam filter string optional プロジェクトのフィルタ。`created` または `participated`。例: created
     * @response 200 {
     *     "id": 1,
     *     "name": "Sample Project",
     *     "description": "This is a sample project.",
     *     "start_date": "2021-01-01",
     *     "end_date": "2021-12-31",
     *     "status_id": 1,
     *     "created_by": 1
     * }
     */
    public function index(Request $request): JsonResponse
    {
        $user = Auth::user();
        // ユーザが作成したプロジェクトまたは参加しているプロジェクトを取得かを判断
        $filter = $request->query('filter', 'participated');

        // プロジェクトを取得
        if ($filter === 'created') {
            // ユーザが作成したプロジェクトを取得
            $projects = $user->projects()->withDetail()->get();
            return response()->json($projects);
        } elseif ($filter === 'participated') {
            // ユーザが参加しているプロジェクトを取得
            $projects = $user->participatedProjects()->withDetail()->get(); // () を追加
            return response()->json($projects);
        } else {
            // フィルタが無効な場合
            return response()->json(['error' => 'Invalid filter'], 400);
        }
    }

    /**
     * プロジェクトを作成します。
     */
    public function store(Request $request)
    {
        // プロジェクトの作成
        $validated = $request->validate([
            'name' => 'required|string|max:255', // プロジェクトの名前(必須、文字列、最大255文字)
            'description' => 'nullable|string',  // プロジェクトの説明(NULL可、文字列)
            'start_date' => 'nullable|date',     // プロジェクト開始日(NULL可、日付)
            'end_date' => 'nullable|date',       // プロジェクトの終了日(NULL可、日付)
        ]);

        // プロジェクトデータを作成
        $projectData = [
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'start_date' => $validated['start_date'] ?? null,
            'end_date' => $validated['end_date'] ?? null,
            'project_status_id' => ProjectStatuses::PENDING,
            'category_id' => Categories::NA,
            'created_by' => Auth::id(),
        ];

        // トランザクションを使用してプロジェクトを作成
        $project = null;

        DB::transaction(function () use ($projectData, &$project) {
            // プロジェクトを作成
            $project = Project::create($projectData);

            // プロジェクト作成者をプロジェクトメンバーに登録
            $project->projectMembers()->attach($project->created_by, ['joined_at' => now()]);

            // デフォルトのロールを作成
            $projectRoles = $project->projectRoles()->createMany([
                [
                    'name' => 'オーナー', 
                    'description' => 'プロジェクトのオーナーです。',
                    'project_role_type_id' => ProjectRoleTypes::DEFAULT,
                ],
                [
                    'name' => '管理者',
                    'description' => 'プロジェクトの管理者です。',
                    'project_role_type_id' => ProjectRoleTypes::DEFAULT,
                ],
                [
                    'name' => 'メンバー',
                    'description' => 'プロジェクトのメンバーです。',
                    'project_role_type_id' => ProjectRoleTypes::DEFAULT,
                ],
            ]);

            // デフォルトのロールに権限を割り当て
            $ownerRole = $projectRoles[0];
            $adminRole = $projectRoles[1];
            $memberRole = $projectRoles[2];

            $ownerRole->projectPermissions()->attach([
                ProjectPermissions::PROJECT_WILDCARD,
                ProjectPermissions::PROJECT_TASK_WILDCARD,
                ProjectPermissions::PROJECT_ROLE_WILDCARD,
                ProjectPermissions::PROJECT_MEMBER_WILDCARD,
                ProjectPermissions::PROJECT_INVITATION_WILDCARD,
            ]);

            $adminRole->projectPermissions()->attach([
                ProjectPermissions::PROJECT_READ,
                ProjectPermissions::PROJECT_UPDATE,
                ProjectPermissions::PROJECT_DELETE,
                ProjectPermissions::PROJECT_TASK_WILDCARD,
                ProjectPermissions::PROJECT_ROLE_WILDCARD,
                ProjectPermissions::PROJECT_MEMBER_WILDCARD,
                ProjectPermissions::PROJECT_INVITATION_WILDCARD,
            ]);

            $memberRole->projectPermissions()->attach([
                ProjectPermissions::PROJECT_READ,
                ProjectPermissions::PROJECT_TASK_WILDCARD,
                ProjectPermissions::PROJECT_ROLE_READ,
                ProjectPermissions::PROJECT_MEMBER_READ,
            ]);

            // プロジェクト作成者にオーナーロールを割り当て
            $ownerRole->projectMembers()->attach([
                $project->created_by => [
                    'project_id' => $project->id,
                    'joined_at' => now(),
                ]
            ]);
        });

        // レスポンス
        return response()->json([
            'message' => 'Project created successfully',
            'project' => $project,
        ], 201);
    }

    /**
     * 指定されたプロジェクトを取得します。
     */
    public function show(Project $project)
    {
        $projectDetail = Project::withDetail()->find($project->id);
        // TODO: ポリシーを使用してプロジェクトの表示権限を確認
        return response()->json($projectDetail, Response::HTTP_OK);
    }

    /**
     * 指定されたプロジェクトを更新します。
     */
    public function update(Request $request, Project $project)
    {
        // TODO: ポリシーを使用してプロジェクトの更新権限を確認

        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'project_status_id' => 'nullable|exists:project_statuses,id',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $project->update($validated);

        return response()->json([
            'message' => 'Project updated successfully',
            'project' => $project,
        ], Response::HTTP_OK);
    }

    /**
     * 指定されたプロジェクトを削除します。
     */
    public function destroy(Project $project)
    {
        // TODO: ポリシーを使用してプロジェクトの削除権限を確認

        $project->delete();

        return response()->json([
            'message' => 'Project deleted successfully',
        ], Response::HTTP_NO_CONTENT);
    }

    public function invite(Request $request, Project $project)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = Auth::user();
        $is_self = $user->id === $validated['user_id'];
        if ($is_self) {
            return response()->json(['error' => 'You cannot invite yourself']);
        }

        // プロジェクト招待を作成
        $project->invitations()->create([
            'invited_by' => $user->id,
            'invitee_id' => $validated['user_id'],
            'status_id' => ProjectInvitationStatuses::PENDING,
            'expires_at' => now()->addDays(7),
        ]);

        return response()->json(['message' => 'Member added successfully'], 200);
    }
    //
    //    public function removeMember(Request $request, Project $project)
    //    {
    //        $this->authorize('update', $project);
    //
    //        $validated = $request->validate([
    //            'user_id' => 'required|exists:users,id',
    //        ]);
    //
    //        // 中間テーブルからメンバーを削除
    //        $project->members()->detach($validated['user_id']);
    //
    //        return response()->json(['message' => 'Member removed successfully'], 200);
    //    }
}
