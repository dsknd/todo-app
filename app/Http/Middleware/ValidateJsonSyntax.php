<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Exceptions\JsonParseException;

class ValidateJsonSyntax
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->isJson()) {
            $content = $request->getContent();

            if (!empty($content)) {
                json_decode($content);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new JsonParseException();
                }
            }
        }

        return $next($request);
    }
}