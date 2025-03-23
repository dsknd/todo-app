<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Exceptions\ApiException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Http\Middleware\Localization;
use App\Exceptions\JsonParseException;
use App\Http\Middleware\ValidateJsonSyntax;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(Localization::class);
        $middleware->append(ValidateJsonSyntax::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // 認証エラー
        $exceptions->renderable(function (AuthenticationException $e, Request $request) {
            return response()->json([
                'type' => 'https://example.com/probs/unauthenticated',
                'title' => __('errors.unauthenticated.title'),
                'status' => Response::HTTP_UNAUTHORIZED,
                'detail' => __('errors.unauthenticated.detail'),
                'instance' => $request->path(),
            ], Response::HTTP_UNAUTHORIZED)->header('Content-Type', 'application/problem+json');
        });

        // JSONパースエラー
        $exceptions->renderable(function (JsonParseException $e, Request $request) {
            return response()->json([
                'type' => 'https://example.com/probs/bad-request',
                'title' => __('errors.json_parse_error.title'),
                'status' => Response::HTTP_BAD_REQUEST,
                'detail' => __('errors.json_parse_error.detail'),
                'instance' => $request->path(),
            ], Response::HTTP_BAD_REQUEST)->header('Content-Type', 'application/problem+json');
        });

        // モデルが見つからない場合の処理
        $exceptions->renderable(function (NotFoundHttpException $e, Request $request) {
            return response()->json([
                'type' => 'https://example.com/probs/resource-not-found',
                'title' => __('errors.resource_not_found.title'),
                'status' => Response::HTTP_NOT_FOUND,
                'detail' => __('errors.resource_not_found.detail'),
                'instance' => $request->path(),
            ], Response::HTTP_NOT_FOUND)->header('Content-Type', 'application/problem+json');
        });

        // 独自のAPIエラー
        $exceptions->renderable(function (ApiException $e, Request $request) {
            return response()->json([
                'type'    => $e->getType(), 
                'title'   => $e->getTitle(),  
                'status'  => $e->getStatus(), 
                'detail'  => $e->getDetail(),  
                'instance'=> $request->path(),
            ], $e->getStatus())->header('Content-Type', 'application/problem+json');
        });

        // バリデーションエラー
        $exceptions->renderable(function (ValidationException $e, Request $request) {
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

            return response()->json([
                'type' => 'https://example.com/probs/validation-error',
                'title' => __('errors.validation_error.title'),
                'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'errors' => $errors
            ], Response::HTTP_UNPROCESSABLE_ENTITY)->header('Content-Type', 'application/problem+json');
        });

        // 内部サーバーエラー
        $exceptions->renderable(function (Exception $e, Request $request) {
            return response()->json([
                'type' => 'https://example.com/probs/internal-server-error',
                'title' => 'Internal Server Error',
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'detail' => 'Unexpected error occurred.',
                'instance' => $request->path(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR)->header('Content-Type', 'application/problem+json');
        });
    })->create();
