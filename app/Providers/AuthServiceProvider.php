<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
//        Category::class => CategoryPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
