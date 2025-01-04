<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProjectTaskCategoryRequest;
use App\Http\Requests\UpdateProjectTaskCategoryRequest;
use App\Models\CustomTaskCategory;
use App\Models\Project;
use App\Models\TaskCategory;
use App\Models\TaskType;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use App\Enums\TaskTypes;

class ProjectTaskCategoryController extends Controller
{
    /**
     * プロジェクト固有のタスクカテゴリを含む、タスクカテゴリ一覧を取得します。
     */
    public function index($projectId)
    {
        // TODO: ポリシーを使用してアクセス制御を実装

        // URLクエリパラメタの検証
        $isProjectExists = Project::where('id', $projectId)->exists();
        if (!$isProjectExists) {
            return response()->json(['message' => 'Project not found.'], Response::HTTP_NOT_FOUND);
        }

        // プロジェクトに関連するタスクカテゴリを取得
        $taskCategories = CustomTaskCategory::withTaskCategories($projectId)->get();

        return response()->json($taskCategories);
    }

    /**
     * プロジェクトタスクカテゴリ作成に必要な情報を取得します。
     */
    public function create($projectId)
    {
        $isProjectExists = Project::where('id', $projectId)->exists();
        if (!$isProjectExists) {
            return response()->json(['message' => 'Project not found.'], Response::HTTP_NOT_FOUND);
        }

        $types = TaskType::all();

        return response()->json([
            'types' => $types,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProjectTaskCategoryRequest $request, string $projectId)
    {
        // ユーザを取得
        $user = auth()->user();

        // URLクエリパラメタの検証
        $isProjectExists = Project::where('id', $projectId)->exists();

        if (!$isProjectExists) {
            return response()->json(['message' => 'Project not found.'], Response::HTTP_NOT_FOUND);
        }

        // タスクカテゴリを作成
        try {
            $taskCategory = DB::transaction(function () use ($request, $user, $projectId) {
                // タスクカテゴリ(スーパータイプ)の作成
                $taskCategory = TaskCategory::create([
                    'name' => $request->input('name'),
                    'description' => $request->input('description'),
                    'is_custom' => true,
                ]);

                // カスタムタスクカテゴリ(サブタイプ)の作成
                $taskCategory->customCategory()->create([
                    'type_id' => TaskTypes::Project,
                    'created_by' => $user->id,
                    'project_id' => $projectId,
                ]);

                return $taskCategory;
            });

            return response()->json($taskCategory->load('customCategory'), Response::HTTP_CREATED);

        } catch (Throwable $e) {
            // その他のエラーが発生した場合
            Log::error('An unexpected error occurred', ['exception' => $e]);
            return response()->json(
                ['message' => 'An unexpected error occurred while creating the task category.'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $projectId, string $categoryId)
    {
        // TODO: ポリシーを使用してアクセス制御を実装

        $taskCategory = CustomTaskCategory::withTaskCategory($categoryId)->firstOrFail();

        return response()->json($taskCategory);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectTaskCategoryRequest $request, string $categoryId)
    {
        // TODO: ポリシーを使用してアクセス制御を実装

        // カスタムタスクカテゴリを更新
        try {
            DB::transaction(function () use ($request, $categoryId) {
                $taskCategory = TaskCategory::where(['id', $categoryId], ['is_custom', true])->firstOrFail();

                $affectedRows = $taskCategory->update([
                    'name' => $request->input('name'),
                    'description' => $request->input('description'),
                ]);

                $isUpdateFailed  = !$affectedRows;
                if ($isUpdateFailed) {
                    throw new Exception('Failed to update the task category.');
                }

                return $taskCategory;
            });

            $taskCategory = TaskCategory::withCustomCategory($categoryId)->firstOrFail();
            return response()->json($taskCategory, Response::HTTP_OK);

        } catch (Throwable) {
            return response()->json(
                ['message' => 'An unexpected error occurred while updating the task category.'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $categoryId)
    {
        // TODO: ポリシーを使用してアクセス制御を実装

        // カスタムタスクカテゴリを削除
        try {
            DB::transaction(function () use ($categoryId) {
                $taskCategory = TaskCategory::where(['id', $categoryId], ['is_custom', true])->firstOrFail();

                $isSubTypeDeleted =  $taskCategory->customCategory()->delete();
                $isSuperTypeDeleted = $taskCategory->delete();

                $isDeleteFailed = !$isSubTypeDeleted || !$isSuperTypeDeleted;
                if ($isDeleteFailed) {
                    throw new Exception('Failed to delete the task category.');
                }
            });

            return response()->json(['message' => 'Task category deleted successfully.'], Response::HTTP_OK);

        } catch (Throwable) {
            return response()->json(
                ['message' => 'An unexpected error occurred while deleting the task category.'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
