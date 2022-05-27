<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('show-user', function (User $user, $id) {
            if ($user->hasRole('administrator')){
                return true;
            }
            return $user->id === (int)$id;
        });

        Gate::define('show-all-users', function (User $user) {
            if ($user->hasRole('administrator') || $user->hasRole('spelbegeleider')){
                return true;
            }
        });

        Gate::define('update-user', function (User $user, $id) {
            if ($user->hasRole('administrator')){
                return true;
            }
            return $user->id === (int)$id;
        });

        Gate::define('store-user', function (User $user) {
            return true;
        });

        Gate::define('show-game', function (User $user, $id) {
            if ($user->hasRole('administrator')){
                return true;
            }
            return $user->id === (int)$id;
        });

        Gate::define('store-gameuser', function (User $user, $gameId){
            return true;
        });
    }
}
