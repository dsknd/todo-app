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
use App\UseCases\CreateProjectUseCase;
use App\DataTransferObjects\CreateProjectDto;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use App\UseCases\UpdateProjectUseCase;
class ProjectController extends Controller
{
    private CreateProjectUseCase $createProjectUseCase;
    private FetchOwnedProjectsUseCase $fetchOwnedProjectsUseCase;
    private FetchParticipatingProjectsUseCase $fetchParticipatingProjectsUseCase;
    private UpdateProjectUseCase $updateProjectUseCase;
    public function __construct(
        CreateProjectUseCase $createProjectUseCase,
        FetchOwnedProjectsUseCase $fetchOwnedProjectsUseCase,
        FetchParticipatingProjectsUseCase $fetchParticipatingProjectsUseCase,
        UpdateProjectUseCase $updateProjectUseCase,
    ) {
        $this->createProjectUseCase = $createProjectUseCase;
        $this->fetchOwnedProjectsUseCase = $fetchOwnedProjectsUseCase;
        $this->fetchParticipatingProjectsUseCase = $fetchParticipatingProjectsUseCase;
        $this->updateProjectUseCase = $updateProjectUseCase;
    }

    /**
     * プロジェクトの一覧を取得します。
     */
    public function index(Request $request)
    {
        $query = ProjectIndexQuery::fromRequest($request);
        $userId = UserId::fromAuth();

        $projects = match(true) {
            $query->isOwnedProjectsRequest() => 
                $this->fetchOwnedProjectsUseCase->execute($userId, $query->perPage),
            default => 
                $this->fetchParticipatingProjectsUseCase->execute($userId),
        };

        return ProjectResource::collection($projects);
    }

    /**
     * プロジェクトを作成します。
     * 
     * @param CreateProjectRequest $request プロジェクト作成リクエスト
     * @return JsonResponse プロジェクトリソース
     */
    public function store(CreateProjectRequest $request): JsonResponse
    {
        // プロジェクトの作成
        $createProjectDto = CreateProjectDto::fromRequest($request);
        $project = $this->createProjectUseCase->execute($createProjectDto);

        // レスポンス
        return new ProjectResource($project)->response()->setStatusCode(Response::HTTP_CREATED);
    }

    // /**
    //  * プロジェクトを更新します。
    //  */
    // public function update(UpdateProjectRequest $request, Project $project): JsonResponse
    // {
    //     $project->update($validated);

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
