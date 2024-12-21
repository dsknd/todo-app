<?php

namespace App\Http\Controllers;

use App\Models\ProjectType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProjectTypeController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $projectTypes = ProjectType::where('user_id', auth()->id())->get();
        return response()->json($projectTypes);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // 新しい ProjectType を作成（is_default は常に false）
        $projectType = ProjectType::create([
            'user_id' => auth()->id(),
            'name' => $validated['name'],
            'is_default' => false,
        ]);

        return response()->json($projectType, 201);
    }

    public function update(Request $request, ProjectType $projectType)
    {
        $this->authorize('update', $projectType);
    
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'is_default' => 'boolean',
        ]);
    
        // デフォルトを切り替える場合も含めて、一度に処理
        DB::transaction(function () use ($validated, $projectType) {
            // ProjectTypeを更新
            $projectType->update([
                'name' => $validated['name'],
            ]);
    
            // デフォルト設定を切り替える場合
            if (!empty($validated['is_default'])) {
                $this->setDefault($projectType);
            }
        });
    
        return response()->json($projectType);
    }

    public function destroy(ProjectType $projectType)
    {
        $this->authorize('delete', $projectType);

        try {
            $projectType->delete();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        }

        return response()->json(['message' => 'Deleted successfully']);
    }

    /**
     * 指定したProjectTypeをデフォルトに設定する
     */
    public function setDefault(ProjectType $projectType)
    {
        // トランザクション内で他のデフォルトを解除し、このProjectTypeをデフォルトに設定
        ProjectType::where('user_id', $projectType->user_id)
            ->where('id', '!=', $projectType->id)
            ->update(['is_default' => false]);

        $projectType->update(['is_default' => true]);
    }
}