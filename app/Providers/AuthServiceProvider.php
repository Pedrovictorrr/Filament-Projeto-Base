<?php

namespace App\Providers;

use App\Models\ActivityLog;
use App\Models\Permission;
use App\Models\Releases;
use App\Models\Role;
use App\Models\User;
use App\Policies\ActivityPolicy;
use App\Policies\ExceptionPolicy;
use App\Policies\PermissionPolicy;
use App\Policies\ReleasePolicy;
use App\Policies\RolePolicy;
use App\Policies\UserPolicy;
use BezhanSalleh\FilamentExceptions\Models\Exception ;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Permission::class => PermissionPolicy::class,
        Role::class => RolePolicy::class,
        ActivityLog::class => ActivityPolicy::class,
        Releases::class => ReleasePolicy::class,
        Exception::class => ExceptionPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
