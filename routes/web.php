<?php

use Illuminate\Support\Facades\Route;

use Dedoc\Scramble\Scramble;
use Dedoc\Scramble\Http\Middleware\RestrictedDocsAccess;

// APIドキュメント
Route::get('/documentation-api', function () {
    return view('scramble::docs', [
        'spec' => file_get_contents(base_path('api.json')),
        'config' => Scramble::getGeneratorConfig('default'),
    ]);
})
->middleware(Scramble::getGeneratorConfig('default')->get('middleware', [RestrictedDocsAccess::class]));

Route::get('/', function () {
    return view('welcome');
});

Route::get('/docs', function () {
    return redirect('/docs/index.html');
});
