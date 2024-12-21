<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\TodoClosure;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Auth::user()->todos;
        return response()->json($todos, 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'due_date' => 'nullable|date',
            'parent_id' => 'nullable|exists:todos,id', // 親が存在する場合
        ]);

        // トランザクション開始
        return DB::transaction(function () use ($validated) {
            // Todo と閉包テーブルを作成
            return $this->storeWithParent($validated);
        });
    }

    public function show(Request $request, $id)
    {
        $todo = Todo::find($id);
    
        if (!$todo) {
            return response()->json(['message' => 'Todo not found'], 404);
        }

        $depth = $request->query('depth', 'all');
        $descendantsQuery = $todo->descendants()->where('todo_closures.descendant_id', '!=', $id);
    
        if ($depth !== 'all') {
            $descendantsQuery->where('todo_closures.depth', '<=', $depth);
        }
    
        $descendants = $descendantsQuery->get();
    
        return response()->json([
            'todo' => $todo,
            'descendants' => $descendants
        ]);
    }

    public function update(Request $request, $id)
    {
        $todo = Auth::user()->todos()->find($id);

        if (!$todo) {
            return response()->json(['message' => 'Todo not found'], 404);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
            'due_date' => 'sometimes|required|date',
            'is_done' => 'sometimes|required|boolean',
        ]);

        $todo->update($validated);

        return response()->json($todo, 200);
    }

    public function destroy($id)
    {
        $todo = Auth::user()->todos()->find($id);

        if (!$todo) {
            return response()->json(['message' => 'Todo not found'], 404);
        }

        $todo->delete();

        return response()->json(['message' => 'Todo deleted successfully'], 200);
    }

    private function storeWithParent(array $validated)
    {
        // 新しいTodoを作成
        $todo = Todo::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'due_date' => $validated['due_date'],
            'user_id' => Auth::id(),
        ]);

        // 自分自身の閉包テーブルエントリを追加
        TodoClosure::create([
            'ancestor_id' => $todo->id,
            'descendant_id' => $todo->id,
            'depth' => 0,
        ]);

        // 親がいる場合、親子関係を閉包テーブルに登録
        if (!empty($validated['parent_id'])) {
            $parentRelations = TodoClosure::where('descendant_id', $validated['parent_id'])->get();

            foreach ($parentRelations as $relation) {
                TodoClosure::create([
                    'ancestor_id' => $relation->ancestor_id,
                    'descendant_id' => $todo->id,
                    'depth' => $relation->depth + 1,
                ]);
            }
        }

        return response()->json($todo, 201);
    }
}