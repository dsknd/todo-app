<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\ValueObjects\LocaleCode;
class Localization
{
    public function handle(Request $request, Closure $next)
    {
        // Accept-Language ヘッダーから言語を取得
        $locale = LocaleCode::fromRequest($request)->getLanguage();

        // Laravelのロケールを設定
        App::setLocale($locale);

        return $next($request);
    }
}
