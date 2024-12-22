<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryTodo;
use Illuminate\Support\Facades\Auth;

class CategoryTodoController extends Controller
{
    public function attach(Request $request, $todoId)
    {
        $todo = Auth::user()->todos()->find($todoId);

        if (!$todo) {
            return response()->json(['message' => 'Todo not found'], 404);
        }

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
        ]);

        $category = Auth::user()->categories()->find($validated['category_id']);
        if (!$category) {
            return response()->json(['message' => 'Category not found or not accessible'], 404);
        }

        $todo->categories()->attach($validated['category_id']);
        return response()->json(['message' => 'Category attached successfully'], 200);
    }

    public function detach(Request $request, $todoId)
    {
        $todo = Auth::user()->todos()->find($todoId);

        if (!$todo) {
            return response()->json(['message' => 'Todo not found'], 404);
        }

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
        ]);

        $category = Auth::user()->categories()->find($validated['category_id']);
        if (!$category) {
            return response()->json(['message' => 'Category not found or not accessible'], 404);
        }

        $todo->categories()->detach($validated['category_id']);
        return response()->json(['message' => 'Category detached successfully'], 200);
    }
}