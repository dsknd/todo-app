<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Exceptions\ApiException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Throwable;
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // 独自のAPIエラーを処理
        $exceptions->renderable(function (ApiException $e, Request $request) {
            return Response::json([
                'type'    => $e->getType(), 
                'title'   => $e->getTitle(),  
                'status'  => $e->getStatus(), 
                'detail'  => $e->getDetail(),  
                'instance'=> $request->path(),
            ], $e->getStatus())->header('Content-Type', 'application/problem+json');
        });

        // バリデーションエラーを処理
        $exceptions->renderable(function (ValidationException $e) {
            $errors = collect($e->validator->errors()->toArray())
                ->map(function ($messages, $field) {
                    return array_map(function ($message) use ($field) {
                        return [
                            'detail' => $message,
                            'pointer' => '#/' . str_replace('.', '/', $field)
                        ];
                    }, (array)$messages);
                })
                ->flatten(1)
                ->values()
                ->all();

            return Response::json([
                'type' => 'https://example.com/probs/validation-error',
                'title' => 'Your request parameters are invalid.',
                'status' => 422,
                'errors' => $errors
            ], 422)->header('Content-Type', 'application/problem+json');
        });

        // 内部サーバーエラーを処理
        $exceptions->renderable(function (Throwable $e, Request $request) {
            return Response::json([
                'type' => 'https://example.com/probs/internal-server-error',
                'title' => 'Internal Server Error',
                'status' => 500,
                'detail' => 'Unexpected error occurred.',
                'instance' => $request->path(),
            ], 500)->header('Content-Type', 'application/problem+json');
        });
    })->create();
