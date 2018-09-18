<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Traits\UserPermissionsTrait;
use App\Policies\OptionPolicy;
use App\Policies\PagePolicy;
use App\Policies\UserPolicy;
use App\Policies\FetchLogPolicy;
use App\Models\Option;
use App\Models\Page;
use App\Models\User;
use App\Models\FetchLog;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Option::class => OptionPolicy::class,
        Page::class => PagePolicy::class,
        User::class => UserPolicy::class,
        FetchLog::class => FetchLogPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(User $user)
    {
        $this->registerPolicies();

        // Gates if you need them.
        Gate::define('admin-functions', function($user) {
            $requiredAdminRoles = ['administrator'];

            return in_array($user->permission->permission, $requiredAdminRoles);
        });

        Gate::define('editor-functions', function($user) {
            $requiredEditorRoles = ['administrator', 'editor'];

            return in_array($user->permission->permission, $requiredEditorRoles);
        });

        Gate::define('viewer-functions', function($user) {
            $requiredViewerRoles = ['administrator', 'editor', 'viewer'];

            return in_array($user->permission->permission, $requiredViewerRoles);
        });
    }
}
