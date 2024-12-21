<?php

namespace App\Providers;

use App\Models\ProjectType;
use App\Policies\ProjectTypePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        ProjectType::class => ProjectTypePolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}