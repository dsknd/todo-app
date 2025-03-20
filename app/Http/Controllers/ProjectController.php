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
use App\UseCases\FetchOwnedProjectsUseCase;
use App\UseCases\FetchParticipatingProjectsUseCase;
use App\Http\Queries\ProjectIndexQuery;
use App\Http\Resources\ProjectResource;
use Illuminate\Http\Request;
use App\ValueObjects\UserId;
use App\Models\User;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class ProjectController extends Controller
{
    private FetchOwnedProjectsUseCase $fetchOwnedProjectsUseCase;
    private FetchParticipatingProjectsUseCase $fetchParticipatingProjectsUseCase;

    public function __construct(
        FetchOwnedProjectsUseCase $fetchOwnedProjectsUseCase,
        FetchParticipatingProjectsUseCase $fetchParticipatingProjectsUseCase,
    ) {
        $this->fetchOwnedProjectsUseCase = $fetchOwnedProjectsUseCase;
        $this->fetchParticipatingProjectsUseCase = $fetchParticipatingProjectsUseCase;
    }

    /**
     * プロジェクトの一覧を取得します。
     * 
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            throw new UnauthorizedHttpException('Bearer', 'Unauthorized');
        }

        $query = ProjectIndexQuery::fromRequest($request);
        $userId = new UserId($user->id->getValue());  // 整数値を取得して新しいUserIdを作成

        $projects = match(true) {
            $query->isOwnedProjectsRequest() => 
                $this->fetchOwnedProjectsUseCase->execute($userId, $query->perPage),
            default => 
                $this->fetchParticipatingProjectsUseCase->execute($userId),
        };

        return ProjectResource::collection($projects);
    }

    // /**
    //  * プロジェクトを作成します。
    //  */
    // public function store(CreateProjectRequest $request): JsonResponse
    // {
    //     // バリデーション

    //     // プロジェクトの作成
    //     // オーナーロールの作成
    //     // レスポンス
    // }

    // /**
    //  * プロジェクトを更新します。
    //  */
    // public function update(UpdateProjectRequest $request, Project $project): JsonResponse
    // {
    //     // バリデーション
    //     $validated = $request->validated();

    //     $project->update($validated);

    //     return response()->json([
    //         'message' => 'Project updated successfully',
    //         'project' => $project,
    //     ], Response::HTTP_OK);
    // }

    // /**
    //  * プロジェクトを削除します。
    //  */
    // public function destroy(Project $project): JsonResponse
    // {
    //     $project->delete();
    //     return response()->json([
    //         'message' => 'Project deleted successfully',
    //     ], Response::HTTP_NO_CONTENT);
    // }
}
