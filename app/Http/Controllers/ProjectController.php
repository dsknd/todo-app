<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\CreateProjectRequest;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\UpdateProjectRequest;
use App\UseCases\FetchOwnedProjectsUseCase;
use App\UseCases\FetchParticipatingProjectsUseCase;
use App\Http\Queries\ProjectIndexQuery;
use App\Http\Resources\ProjectResource;
use Illuminate\Http\Request;
use App\ValueObjects\UserId;
use App\UseCases\CreateProjectUseCase;
use App\DataTransferObjects\CreateProjectDto;
use App\UseCases\UpdateProjectUseCase;
use App\DataTransferObjects\UpdateProjectDto;
use App\UseCases\DeleteProjectUseCase;
use App\Models\Project;
use App\UseCases\FindProjectUseCase;
use Illuminate\Support\Facades\Gate;
class ProjectController extends Controller
{
    private CreateProjectUseCase $createProjectUseCase;
    private FetchOwnedProjectsUseCase $fetchOwnedProjectsUseCase;
    private FetchParticipatingProjectsUseCase $fetchParticipatingProjectsUseCase;
    private UpdateProjectUseCase $updateProjectUseCase;
    private DeleteProjectUseCase $deleteProjectUseCase;
    private FindProjectUseCase $findProjectUseCase;
    public function __construct(
        CreateProjectUseCase $createProjectUseCase,
        FetchOwnedProjectsUseCase $fetchOwnedProjectsUseCase,
        FetchParticipatingProjectsUseCase $fetchParticipatingProjectsUseCase,
        UpdateProjectUseCase $updateProjectUseCase,
        DeleteProjectUseCase $deleteProjectUseCase,
        FindProjectUseCase $findProjectUseCase,
    ) {
        $this->createProjectUseCase = $createProjectUseCase;
        $this->fetchOwnedProjectsUseCase = $fetchOwnedProjectsUseCase;
        $this->fetchParticipatingProjectsUseCase = $fetchParticipatingProjectsUseCase;
        $this->updateProjectUseCase = $updateProjectUseCase;
        $this->deleteProjectUseCase = $deleteProjectUseCase;
        $this->findProjectUseCase = $findProjectUseCase;
    }

    /**
     * プロジェクトの一覧を取得します。
     * 
     * @param Request $request リクエスト
     * @return JsonResponse プロジェクトリソース
     */
    public function index(Request $request): JsonResponse
    {
        $query = ProjectIndexQuery::fromRequest($request);
        $userId = UserId::fromAuth();

        $projects = match(true) {
            $query->isOwnedProjectsRequest() => 
                $this->fetchOwnedProjectsUseCase->execute($userId, $query->perPage),
            default => 
                $this->fetchParticipatingProjectsUseCase->execute($userId),
        };

        return ProjectResource::collection($projects)->response()->setStatusCode(Response::HTTP_OK);
    }

    /**
     * プロジェクトを取得します。
     * 
     * @param Project $project プロジェクト
     * @return JsonResponse プロジェクトリソース
     */
    public function show(Project $project): JsonResponse
    {
        $userId = UserId::fromAuth();
        $project = $this->findProjectUseCase->execute($project->id);

        return new ProjectResource($project)->response()->setStatusCode(Response::HTTP_OK);
    }
    /**
     * プロジェクトを作成します。
     * 
     * @param CreateProjectRequest $request プロジェクト作成リクエスト
     * @return JsonResponse プロジェクトリソース
     */
    public function store(CreateProjectRequest $request): JsonResponse
    {
        // プロジェクトの作成権限を確認
        Gate::authorize('create', Project::class);

        // プロジェクトの作成
        $createProjectDto = CreateProjectDto::fromRequest($request);
        $project = $this->createProjectUseCase->execute($createProjectDto);

        // レスポンス
        return new ProjectResource($project)->response()->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * プロジェクトを更新します。
     * 
     * @param Project $project プロジェクト
     * @param UpdateProjectRequest $request プロジェクト更新リクエスト
     * @return JsonResponse プロジェクトリソース
     */
    public function update(Project $project, UpdateProjectRequest $request): JsonResponse
    {
        // プロジェクトの更新権限を確認
        Gate::authorize('update', $project);

        // プロジェクトの更新
        $updateProjectDto = UpdateProjectDto::fromRequest($request);
        $project = $this->updateProjectUseCase->execute($project->id, $updateProjectDto);

        // レスポンス
        return new ProjectResource($project)->response()->setStatusCode(Response::HTTP_OK);

    }

    /**
     * プロジェクトを削除します。
     * 
     * @param Project $project プロジェクト
     * @return JsonResponse プロジェクトリソース
     */
    public function destroy(Project $project): JsonResponse
    {
        $this->deleteProjectUseCase->execute($project->id);
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
