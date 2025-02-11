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
class ProjectController extends Controller
{
    /**
     * プロジェクトを作成します。
     */
    public function store(CreateProjectRequest $request): JsonResponse
    {
        // バリデーション
        $validated = $request->validated();

        $data = $validated;
        $data['project_status_id'] = ProjectStatusEnum::PLANNING->value;
        $data['user_id'] = Auth::id();

        // トランザクションを使用してプロジェクトを作成
        $project = null;

        try {
            DB::transaction(function () use ($validated, &$project) {
                $project = Project::create($validated);

                // TODO: デフォルトロールの作成

                // TODO: デフォルトパーミッション割当
            });
        } catch (Throwable $e) {

        }

        // レスポンス
        return response()->json([
            'message' => 'Project created successfully',
            'project' => $project,
        ], Response::HTTP_CREATED);
    }
}
