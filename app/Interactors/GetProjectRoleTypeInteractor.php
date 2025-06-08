<?php

namespace App\Interactors;

use App\Repositories\Interfaces\ProjectRoleTypeQueryRepository;
use App\UseCases\GetProjectRoleTypeUseCase;
use App\ValueObjects\LocaleCode;
use Illuminate\Support\Collection;


class GetProjectRoleTypeInteractor implements GetProjectRoleTypeUseCase
{
    public function __construct(
        private readonly ProjectRoleTypeQueryRepository $projectRoleTypeQueryRepository
    ) {
    }

    public function execute(LocaleCode $localeCode): Collection
    {
        return $this->projectRoleTypeQueryRepository->get($localeCode);
    }
}