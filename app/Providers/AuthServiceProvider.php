<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;


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

        Passport::routes();
        Passport::cookie('alturush_admin_token');

        Gate::define('isAdmin', function () {
            return Auth::user()->usertype_id === 6 ;
        });
        Gate::define('isSuperAdmin', function () {
            return Auth::user()->usertype_id === 12;
        });
        Gate::define('isIAD', function () {
            return Auth::user()->usertype_id === 7;
        });
        Gate::define('isPurchasing', function () {
            return Auth::user()->usertype_id === 15;
        });
        // Gate::define('isGGM', function () {
        //     return Auth::user()->usertype_id === 6;
        // });
        // Gate::define('isGoodsIAD', function () {
        //     return Auth::user()->usertype_id === 18;
        // });

        // Gate::define('isAccounting', function () {
        //     return Auth::user()->usertype_id === 8;
        // });
        // Gate::define('isSupervisor', function () {
        //     return Auth::user()->usertype_id === 14;
        // });

    }
}
