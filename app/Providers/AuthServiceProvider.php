<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\ProjectType;
use App\Policies\ProjectTypePolicy;
use App\Models\Category;
use App\Policies\CategoryPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        ProjectType::class => ProjectTypePolicy::class,
        Category::class => CategoryPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}