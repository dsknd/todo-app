<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Todo;
use App\Models\TodoClosure;

class TodoRelationshipController extends Controller
{
    // 親子関係をアタッチする
    public function attach(Request $request, $todoId)
    {
        $validated = $request->validate([
            'parent_id' => 'required|exists:todos,id', // 親が存在することを確認
        ]);

        $user = Auth::user();

        // トランザクションで安全に関係を更新
        return DB::transaction(function () use ($todoId, $validated, $user) {
            // 子Todoを取得
            $childTodo = $user->todos()->findOrFail($todoId);

            // 親の閉包テーブルを取得
            $parentRelations = TodoClosure::where('descendant_id', $validated['parent_id'])->get();

            // 自分自身の閉包テーブルエントリを削除
            TodoClosure::where('descendant_id', $childTodo->id)->delete();

            // 新しい親子関係を作成
            foreach ($parentRelations as $relation) {
                TodoClosure::create([
                    'ancestor_id' => $relation->ancestor_id,
                    'descendant_id' => $childTodo->id,
                    'depth' => $relation->depth + 1,
                ]);
            }

            // 自分自身を閉包テーブルに追加
            TodoClosure::create([
                'ancestor_id' => $childTodo->id,
                'descendant_id' => $childTodo->id,
                'depth' => 0,
            ]);

            return response()->json(['message' => 'Parent attached successfully']);
        });
    }

    // 親子関係をデタッチする
    public function detach($todoId)
    {
        $user = Auth::user();

        // トランザクションで安全に関係を解除
        return DB::transaction(function () use ($todoId, $user) {
            // 子Todoを取得
            $childTodo = $user->todos()->findOrFail($todoId);

            // 自分自身を含む閉包テーブルを削除
            TodoClosure::where('descendant_id', $childTodo->id)->delete();

            // 自分自身のみ閉包テーブルに追加
            TodoClosure::create([
                'ancestor_id' => $childTodo->id,
                'descendant_id' => $childTodo->id,
                'depth' => 0,
            ]);

            return response()->json(['message' => 'Parent detached successfully']);
        });
    }
}