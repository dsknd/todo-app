<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\ProjectMember;
use App\Policies\ProjectMemberPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        ProjectMember::class => ProjectMemberPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
