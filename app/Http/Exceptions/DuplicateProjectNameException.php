<?php

namespace App\Http\Exceptions;

use Throwable;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Lang;

class DuplicateProjectNameException extends ApiException
{
    const TYPE = 'https://example.com/probs/duplicate-project-name';
    const STATUS = Response::HTTP_BAD_REQUEST;

    private string $title;
    private string $detail;

    public function __construct(
        ?Throwable $previous = null
    ) {
        // エラーメッセージを取得
        $this->title = Lang::get('errors.duplicate_project_name.title');
        $this->detail = Lang::get('errors.duplicate_project_name.detail');

        // 親クラスのコンストラクタを呼び出す
        parent::__construct(
            self::TYPE,
            self::STATUS,
            $this->title,
            $this->detail,
            $previous
        );
    }
}