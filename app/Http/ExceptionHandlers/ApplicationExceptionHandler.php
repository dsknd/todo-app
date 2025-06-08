<?php

namespace App\Http\ExceptionHandlers;

use App\UseCases\Exceptions\ApplicationException;
use App\Enums\ErrorCodeEnum;
use App\Http\Exceptions\DuplicateProjectNameException;
use App\Http\Exceptions\ApiException;
use Illuminate\Http\Response;

class ApplicationExceptionHandler
{
    /**
     * アプリケーション層の例外をHTTPレイヤーの例外に変換します。
     * 
     * @param callable $callback ユースケース
     * @return mixed ユースケースの結果
     * @throws ApiException
     */
    public static function handle(callable $callback): mixed
    {
        try {
            return $callback();
        } catch (ApplicationException $e) {
            throw self::toApiException($e);
        }
    }

    /**
     * アプリケーション層の例外をプレゼンテーション層の例外に変換します。
     */
    private static function toApiException(ApplicationException $e): ApiException
    {
        return match($e->getCode()) {
            ErrorCodeEnum::DUPLICATE_PROJECT_NAME->value => new DuplicateProjectNameException($e->getPrevious()),
            default => 
                new ApiException(
                    type: 'https://example.com/probs/internal-server-error',
                    status: Response::HTTP_INTERNAL_SERVER_ERROR,
                    title: 'Internal Server Error',
                    detail: $e->getMessage(),
                    previous: $e->getPrevious()
                )
        };
    }
}