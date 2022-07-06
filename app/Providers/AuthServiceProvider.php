<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Auth;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        /* define a admin user role */

        Gate::define('isAdmin', function($user) {

            return $user->type == 1;
 
        });

        Gate::define('isUser', function($user) {
            return $user->type == 2;
        });

        Gate::define('canDelete', function($user,$post) {
            return $user->id==$post->user_id;
        });
        //
    }
}
