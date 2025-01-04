<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProjectTaskCategoryRequest;
use App\Models\Project;
use App\Models\TaskCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Exception;
use Throwable;

class TaskCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // TODO: ポリシーを使用してアクセス制御を実装

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(TaskCategory $taskCategory)
    {
        // TODO: ポリシーを使用してアクセス制御を実装

        return response()->json($taskCategory);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // TODO: ポリシーを使用してアクセス制御を実装

        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'is_personal' => 'nullable|boolean',
            'is_project' => 'nullable|boolean',
            'project_id' => 'nullable|exists:projects,id',
            'created_by' => 'nullable|exists:users,id',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
