<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('all-users', function ($user) {   return $user->hasAnyRoles(['admin', 'manager', 'employee']);  });
        Gate::define('admin-manager-only', function ($user) {   return $user->hasAnyRoles(['admin', 'manager']);  });
        Gate::define('manager-employee-only', function ($user) {   return $user->hasAnyRoles(['employee', 'manager']);  });
        Gate::define('admin-only', function ($user) {   return $user->hasRole('admin');  });
        Gate::define('manager-only', function ($user) {   return $user->hasRole('manager');  });
        Gate::define('employee-only', function ($user) {   return $user->hasRole('employee');  });
    }
}
