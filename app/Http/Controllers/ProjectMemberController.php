<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\UseCases\GetProjectMemberUseCase;
use App\Http\Resources\ProjectMemberResource;
use App\Http\Queries\ProjectMemberIndexUrlQueryParams;
use Illuminate\Http\Response;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class ProjectMemberController extends Controller
{
    /**
     * コンストラクタ
     *
     * @param GetProjectMemberUseCase $getProjectMemberUseCase
     */
    public function __construct(
        private readonly GetProjectMemberUseCase $getProjectMemberUseCase
    ) {
    }


    /**
     * プロジェクトメンバーを取得します。
     * 
     * @param Project $project プロジェクト
     * @return JsonResponse プロジェクトメンバー
     */
    public function index(Project $project, Request $request)
    {
        // 権限の確認
        Gate::authorize('viewAny', $project);

        // クエリパラメータの取得
        $urlQueryParams = ProjectMemberIndexUrlQueryParams::fromRequest($request);

        // プロジェクトメンバーの取得
        $projectMembers = $this->getProjectMemberUseCase->execute(
            $urlQueryParams->getProjectId(),
            $urlQueryParams->getPageSize(),
            $urlQueryParams->getSortOrders()
        );

        // プロジェクトメンバーの返却
        return ProjectMemberResource::paginatedCollection(
            $projectMembers,
            $request,
            Response::HTTP_OK
        );
    }

    /**
     * プロジェクトメンバーを追加します。
     * 
     * @param Project $project プロジェクト
     * @param Request $request リクエスト
     * @return JsonResponse プロジェクトメンバー
     */
    public function store(Project $project, Request $request)
    {
        // TODO: 権限の確認
        // TODO: プロジェクトメンバーの追加
        // TODO: プロジェクトメンバーの返却
    }

    /**
     * プロジェクトメンバーを削除します。
     * 
     * @param Project $project プロジェクト
     * @param User $user ユーザー
     * @return JsonResponse プロジェクトメンバー
     */
    public function destroy(Project $project, User $user)
    {
        // TODO: 権限の確認
        // TODO: プロジェクトメンバーの削除
        // TODO: プロジェクトメンバーの返却
    }
    
    /**
     * プロジェクトメンバーを更新します。
     * 
     * @param Project $project プロジェクト
     * @param User $user ユーザー
     * @param Request $request リクエスト
     * @return JsonResponse プロジェクトメンバー
     */
    public function update(Project $project, User $user, Request $request)
    {
        // TODO: 権限の確認
        // TODO: プロジェクトメンバーの更新
        // TODO: プロジェクトメンバーの返却
    }
}
