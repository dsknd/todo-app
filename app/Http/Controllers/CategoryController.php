<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Policies\CategoryPolicy;

class CategoryController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $categories = Auth::user()->categories;
        return response()->json($categories, 200);
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);

        // 認可チェック
        $this->authorize('view', $category);

        return response()->json($category, 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:categories,name,NULL,id,user_id,' . auth()->id(),

        ]);

        $category = Category::create([
            'name' => $validated['name'],
            'user_id' => auth()->id(),
        ]);

        return response()->json($category, 201);
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        // 認可チェック
        $this->authorize('update', $category);

        $validated = $request->validate([
            'name' => 'required|string|unique:categories,name,' . $id . ',id,user_id,' . Auth::id(),
        ]);

        $category->update($validated);

        return response()->json($category, 200);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // 認可チェック
        $this->authorize('delete', $category);

        $category->delete();

        return response()->json(['message' => 'Category deleted successfully'], 200);
    }
}