<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CreateProjectRequest;
use App\Enums\ProjectStatusEnum;
use Throwable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\ProjectRole;
use App\Enums\DefaultProjectRolePresetEnum;
use App\Models\LocaleEnum;

class ProjectController extends Controller
{
    /**
     * プロジェクトの一覧を取得します。
     * 
     * URLクエリパラメータ
     * - filter: (created, participated, all)
     * 
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        // URLクエリパラメータ
        $filter = request()->query('filter', null);

        // クエリビルダ
        $query = Project::query();

        if ($filter === 'created') {
            // ユーザ自身が作成したプロジェクトのみ取得する
            $query->where('user_id', Auth::id());
        } elseif ($filter === 'participated') {
            // ユーザ自身がメンバーとなっているプロジェクトのみ取得する
            $query->with(['members' => function ($query) {
                $query->where('user_id', Auth::id());
            }]);
        } else {
            // allの場合は参加しているプロジェクトと作成したプロジェクトを取得する
            $query->with(['members' => function ($query) {
                $query->where('user_id', Auth::id());
            }])->orWhere('user_id', Auth::id());
        }
        $projects = $query->get();
        return response()->json([
            'message' => 'Projects fetched successfully',
            'projects' => $projects,
        ], Response::HTTP_OK);
    }

    /**
     * プロジェクトを作成します。
     */
    public function store(CreateProjectRequest $request): JsonResponse
    {
        // バリデーション
        $validated = $request->validated();

        // データの作成
        $data = $validated;
        $data['project_status_id'] = ProjectStatusEnum::PLANNING->value;
        $data['user_id'] = Auth::id();
        $data['is_private'] = false;

        // トランザクションを使用してプロジェクトを作成
        $project = null;

        $requestHeaderLocale = $request->header('Accept-Language');
        try {
            DB::transaction(function () use ($data, &$project) {
                $project = Project::create($data);

                // TODO: デフォルトロールの作成

                // TODO: デフォルトパーミッション割当
            });
        } catch (Throwable $e) {
            return response()->json([
                'message' => 'Project creation failed',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        // レスポンス
        return response()->json([
            'message' => 'Project created successfully',
            'project' => $project,
        ], Response::HTTP_CREATED);
    }

    /**
     * プロジェクトを更新します。
     */
    public function update(UpdateProjectRequest $request, Project $project): JsonResponse
    {
        // バリデーション
        $validated = $request->validated();

        $project->update($validated);

        return response()->json([
            'message' => 'Project updated successfully',
            'project' => $project,
        ], Response::HTTP_OK);
    }

    /**
     * プロジェクトを削除します。
     */
    public function destroy(Project $project): JsonResponse
    {
        $project->delete();
        return response()->json([
            'message' => 'Project deleted successfully',
        ], Response::HTTP_NO_CONTENT);
    }
}
