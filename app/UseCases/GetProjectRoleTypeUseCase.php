<?php

namespace App\UseCases;

use App\ValueObjects\LocaleCode;
use Illuminate\Support\Collection;

interface GetProjectRoleTypeUseCase
{
    public function execute(LocaleCode $localeCode): Collection;
}