<?php

namespace App\UseCases;

use Illuminate\Support\Collection;

interface GetDefaultProjectRoleUseCase
{
    /**
     * すべてのデフォルトプロジェクトロールを取得
     *
     * @return Collection<DefaultProjectRole>
     */
    public function execute(): Collection;
}