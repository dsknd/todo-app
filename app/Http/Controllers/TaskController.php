<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatusEnum;
use App\Models\Task;
use App\Http\Requests\TaskRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\CreateTaskRequest;
use Illuminate\Support\Facades\Auth;
use App\Enums\PriorityEnum;
use App\Enums\CategoryEnum;
use App\Models\Project;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
class TaskController extends Controller
{
    /**
     * タスク一覧を取得
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $tasks = Task::with([
                'status',
                'assignees',
                'category',
                'tags',
                'creator',
                'updater',
            ])->filter($request->all())
              ->orderBy('created_at', 'desc')
              ->paginate($request->input('per_page', 15));

            return response()->json($tasks);
        } catch (\Exception $e) {
            Log::error('タスク一覧の取得に失敗しました。', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'タスク一覧の取得に失敗しました。'], 500);
        }
    }

    /**
     * タスクを新規作成
     */
    public function store(CreateTaskRequest $request, Project $project): JsonResponse
    {
        try {
            // バリデーション
            $request->validated();

            // データの作成
            $data = $request->validated();
            $data['project_id'] = $project->id;
            $data['user_id'] = Auth::id();
            $data['priority_id'] = $request->priority_id ?? PriorityEnum::LOW;
            $data['status_id'] = $request->status_id ?? TaskStatusEnum::NOT_STARTED;
            $data['category_id'] = $request->category_id ?? CategoryEnum::UNCATEGORIZED;

            $task = null;

            DB::transaction(function () use ($data, &$task) {
                $task = Task::create($data);
            });

            if ($request->is_recurring) {
                // TODO: リマインダーの作成
            }

            return response()->json([
                'message' => 'タスクを作成しました。',
                'task' => $task,
            ], Response::HTTP_CREATED);

        } catch (ValidationException $e) {
            Log::error('タスクの作成に失敗しました。', ['error' => $e->getMessage()]);
            return response()->json(
                [
                    'message' => 'タスクの作成に失敗しました。',
                    'error' => $e->getMessage(),
                ],
                Response::HTTP_BAD_REQUEST
            );
        } catch (\Exception $e) {
            Log::error('タスクの作成に失敗しました。', ['error' => $e->getMessage()]);
            return response()->json(
                [
                    'message' => 'タスクの作成に失敗しました。',
                    'error' => $e->getMessage(),
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * タスクの詳細を取得
     */
    public function show(Task $task): JsonResponse
    {
        try {
            return response()->json($task->load([
                'status',
                'assignees',
                'category',
                'tags',
                'importance',
                'urgency',
                'creator',
                'updater',
                'histories.type',
                'histories.creator',
            ]));
        } catch (\Exception $e) {
            Log::error('タスクの取得に失敗しました。', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'タスクの取得に失敗しました。'], 500);
        }
    }

    /**
     * タスクを更新
     */
    // public function update(TaskRequest $request, Task $task): JsonResponse
    // {
    //     try {
    //         DB::beginTransaction();

    //         $task->update([
    //             'title' => $request->title,
    //             'description' => $request->description,
    //             'status_id' => $request->status_id,
    //             'category_id' => $request->category_id,
    //             'importance_id' => $request->importance_id,
    //             'urgency_id' => $request->urgency_id,
    //             'planned_start_date' => $request->planned_start_date,
    //             'planned_end_date' => $request->planned_end_date,
    //             'actual_start_date' => $request->actual_start_date,
    //             'actual_end_date' => $request->actual_end_date,
    //             'updated_by' => auth()->id(),
    //         ]);

    //         // 担当者の更新
    //         if ($request->has('assignee_ids')) {
    //             $task->assignees()->sync($request->assignee_ids);
    //         }

    //         // タグの更新
    //         if ($request->has('tag_ids')) {
    //             $task->tags()->sync($request->tag_ids);
    //         }

    //         DB::commit();

    //         return response()->json($task->load([
    //             'status',
    //             'assignees',
    //             'category',
    //             'tags',
    //             'importance',
    //             'urgency',
    //             'creator',
    //             'updater',
    //         ]));

    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         Log::error('タスクの更新に失敗しました。', ['error' => $e->getMessage()]);
    //         return response()->json(['message' => 'タスクの更新に失敗しました。'], 500);
    //     }
    // }

    /**
     * タスクを削除
     */
    public function destroy(Task $task): JsonResponse
    {
        try {
            DB::beginTransaction();

            $task->delete();

            DB::commit();

            return response()->json(null, 204);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('タスクの削除に失敗しました。', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'タスクの削除に失敗しました。'], 500);
        }
    }
} 