<?php

namespace App\Interactors;

use App\UseCases\GetDefaultProjectRoleUseCase;
use App\Repositories\Interfaces\DefaultProjectRoleRepository;
use Illuminate\Support\Collection;

class GetDefaultProjectRoleInteractor implements GetDefaultProjectRoleUseCase
{
    public function __construct(
        private readonly DefaultProjectRoleRepository $defaultProjectRoleRepository
    ) {
    }

    /**
     * @inheritDoc
     */
    public function execute(): Collection
    {
        // すべてのデフォルトプロジェクトロールを取得
        $defaultProjectRoles = $this->defaultProjectRoleRepository->get();

        // デフォルトプロジェクトロールを返却
        return $defaultProjectRoles;
    }
}