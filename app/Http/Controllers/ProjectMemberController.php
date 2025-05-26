<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectMember;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
class ProjectMemberController extends Controller
{

    /**
     * プロジェクトメンバーを取得します。
     * 
     * @param Project $project プロジェクト
     * @return JsonResponse プロジェクトメンバー
     */
    public function index(Project $project)
    {
        // TODO: 権限の確認
        // TODO: プロジェクトメンバーの取得

        // TODO: プロジェクトメンバーの返却

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
