<?php

namespace App\Http\Exceptions;

use Throwable;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Lang;

class CreateProjectFailureException extends ApiException
{
    const TYPE = 'https://example.com/probs/create-project-failure';
    const STATUS = Response::HTTP_INTERNAL_SERVER_ERROR;

    private string $title;
    private string $detail;

    public function __construct(
        ?Throwable $previous = null
    ) {
        $this->title = Lang::get('errors.create_project_failure.title');
        $this->detail = Lang::get('errors.create_project_failure.detail');

        parent::__construct(
            self::TYPE,
            self::STATUS,
            $this->title,
            $this->detail,
            $previous
        );
    }
}