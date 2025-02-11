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
        $project_id = $request->query('project_id');
        $status_id = $request->query('status_id', TaskStatusEnum::NOT_STARTED);
        $category_id = $request->query('category_id', CategoryEnum::UNCATEGORIZED);
        $priority_id = $request->query('priority_id', PriorityEnum::NONE);
        $planned_start_date = $request->query('planned_start_date', now()->format('Y-m-d'));
        $planned_end_date = $request->query('planned_end_date', now()->format('Y-m-d'));
        $actual_start_date = $request->query('actual_start_date', now()->format('Y-m-d'));
        $actual_end_date = $request->query('actual_end_date', now()->format('Y-m-d'));
        $is_recurring = $request->query('is_recurring', false);
        $sort_by = $request->query('sort_by', 'created_at');
        $sort_order = $request->query('sort_order', 'desc');
        $per_page = $request->query('per_page', 15);

        try {
            $query = Task::with(['status', 'category', 'creator'])
                ->where('project_id', $project_id);

            // オプショナルな条件を追加
            if ($request->has('status_id')) {
                $query->where('status_id', $status_id);
            }

            if ($request->has('planned_start_date')) {
                $query->whereDate('planned_start_date', '>=', $planned_start_date);
            }

            if ($request->has('planned_end_date')) {
                $query->whereDate('planned_end_date', '<=', $planned_end_date);
            }

            if ($request->has('category_id')) {
                $query->where('category_id', $category_id);
            }

            if ($request->has('priority_id')) {
                $query->where('priority_id', $priority_id);
            }

            if ($request->has('actual_start_date')) {
                $query->where('actual_start_date', $actual_start_date);
            }

            if ($request->has('actual_end_date')) {
                $query->where('actual_end_date', $actual_end_date);
            }

            if ($request->has('is_recurring')) {
                $query->where('is_recurring', $is_recurring);
            }

            $tasks = $query->filter($request->all())
                ->orderBy($sort_by, $sort_order)
                ->paginate($per_page);

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