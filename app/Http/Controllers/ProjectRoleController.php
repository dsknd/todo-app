<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectRole;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class ProjectRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        // TODO: ポリシーを使用してプロジェクトロールの作成権限を確認

        // validate
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'user_id' => 'required|exists:users,id',
            'scope' => 'required|in:admin,member',
        ]);

        // create project role
        $projectRole = ProjectRole::create($validated);

        return response()->json($projectRole, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // TODO: ポリシーを使用してプロジェクトロールの表示権限を確認

        $projectRole = ProjectRole::findOrFail($id);
        return response()->json($projectRole, Response::HTTP_OK);
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
    public function update(Request $request, string $id)
    {
        // TODO: ポリシーを使用してプロジェクトロールの編集権限を確認

        // validate
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $id) {
            $projectRole = ProjectRole::findOrFail($id);
            $projectRole->update($request->all());
        });

        return response()->json(['message' => 'Project role updated successfully'], Response::HTTP_OK);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
