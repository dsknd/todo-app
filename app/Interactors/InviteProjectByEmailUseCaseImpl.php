<?php

namespace App\Interactors;

use Exception;
use App\ValueObjects\ErrorCode;
use App\Enums\ErrorCodeEnum;
use App\UseCases\Exceptions\InviteProjectByEmailFailedException;
use App\UseCases\InviteProjectByEmailUseCase;

class InviteProjectByEmailInteractor implements InviteProjectByEmailUseCase
{
    public function execute(string $email, string $projectId): void
    {
        // TODO: 招待レコードの作成
        // TODO: 招待メールの送信
    }
} 