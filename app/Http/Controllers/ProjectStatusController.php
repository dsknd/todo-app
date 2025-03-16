<?php

namespace App\Http\Controllers;

use App\Models\ProjectStatus;
use Illuminate\Http\JsonResponse;

class ProjectStatusController
{
    /**
     * プロジェクトステータス一覧を取得
     */
    public function index(): JsonResponse
    {
        return response()->json(ProjectStatus::all());
    }

    /**
     * 特定のプロジェクトステータスを取得
     */
    public function show(ProjectStatus $projectStatus): JsonResponse
    {
        return response()->json($projectStatus);
    }
}
