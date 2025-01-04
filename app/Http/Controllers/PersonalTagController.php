<?php

namespace App\Http\Controllers;

use App\Enums\OwnershipTypes;
use App\Models\OwnershipType;
use App\Models\PersonalTag;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PersonalTagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            Log::info('Attempting to retrieve personal tags');

            // ユーザー自身のタグのみを検索
            $tags = Tag::withPeronalTagDetailByUserId(Auth::id())->get();

            Log::info('Personal tags retrieved: ', ['tags' => $tags]);

            return response()->json($tags);

        } catch (Throwable $e) {
            Log::error('Exception occurred while retrieving personal tags', ['exception' => $e]);
            return response()->json(['error' => 'Failed to retrieve personal tags'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'string|nullable',
        ]);

        try {
            $tag = DB::transaction(function () use ($validated) {
                $tag = Tag::create([
                    'name' => $validated['name'],
                    'description' => $validated['description'],
                    'ownership_type_id' => OwnershipTypes::Personal,
                    'created_by' => Auth::id(),
                ]);

                PersonalTag::create([
                    'user_id' => Auth::id(),
                    'tag_id' => $tag->id,
                ]);

                return $tag;
            });
            return response()->json($tag, 201);

        } catch (Throwable $e) {
            Log::error('Exception occurred', ['exception' => $e]);
            return response()->json(['error' => 'Failed to create a personal tag'], 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show($tagId)
    {
        try {
            Log::info('Attempting to retrieve tag with id: ' . $tagId);

            // ユーザー自身のタグのみを検索
            $tag = Tag::withPersonalTagDetailByTagId($tagId)
                ->first();

            Log::info('Tag retrieved: ', ['tag' => $tag]);

            return response()->json($tag);

        } catch (ModelNotFoundException $e) {
            Log::warning('Tag not found with id: ' . $tagId);
            return response()->json(['error' => 'Tag not found'], 404);

        } catch (Throwable $e) {
            Log::error('Exception occurred while retrieving the tag', ['exception' => $e]);
            return response()->json(['error' => 'Failed to retrieve the tag'], 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            Log::info('Attempting to update tag with id: ' . $id);

            // バリデーション: 必要なフィールドをチェック
            $validated = $request->validate([
                'name' => 'string|max:255',
                'description' => 'string|nullable',
            ]);

            // タグを取得
            $tag = Tag::findOrFail($id);

            // リクエストに含まれるフィールドのみを更新
            $tag->update(array_filter($validated, fn($value) => $value !== null));

            Log::info('Tag updated: ', ['tag' => $tag]);

            return response()->json($tag);

        } catch (ModelNotFoundException $e) {
            Log::warning('Tag not found with id: ' . $id);
            return response()->json(['error' => 'Tag not found'], 404);

        } catch (Throwable $e) {
            Log::error('Exception occurred while updating the tag', ['exception' => $e]);
            return response()->json(['error' => 'Failed to update the tag'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Log::info('Attempting to delete tag with id: ' . $id);

            $tag = Tag::findOrFail($id);

            // ユーザー自身のタグのみを削除
            PersonalTag::where('tag_id', $id)
                ->where('user_id', Auth::id())
                ->delete();

            Tag::destroy($id);

            Log::info('Tag deleted: ', ['tag' => $tag]);

            return response()->json(['message' => 'Tag deleted successfully']);

        } catch (ModelNotFoundException $e) {
            Log::warning('Tag not found with id: ' . $id);
            return response()->json(['error' => 'Tag not found'], 404);

        } catch (Throwable $e) {
            Log::error('Exception occurred while deleting the tag', ['exception' => $e]);
            return response()->json(['error' => 'Failed to delete the tag'], 500);
        }
    }
}
