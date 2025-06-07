<?php

namespace App\Http\Resources\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\CursorPaginator;

trait Paginatable
{
    /**
     * カーソルページネーション付きのコレクションレスポンスを作成
     *
     * @param CursorPaginator $paginator
     * @param Request $request
     * @param int $statusCode
     * @return JsonResponse
     */
    public static function paginatedCollection(CursorPaginator $paginator, Request $request, int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'data' => static::collection($paginator->items())->toArray($request),
            'pagination' => [
                'has_more_pages' => $paginator->hasMorePages(),
                'next_cursor' => $paginator->nextCursor()?->encode(),
                'per_page' => $paginator->perPage(),
            ]
        ], $statusCode);
    }
}