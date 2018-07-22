<?php

namespace LaravelACL\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\LaravelACL\Repositories\UserRepository::class, \LaravelACL\Repositories\UserRepositoryEloquent::class);
        $this->app->bind(\LaravelACL\Repositories\RoleRepository::class, \LaravelACL\Repositories\RoleRepositoryEloquent::class);
        $this->app->bind(\LaravelACL\Repositories\PermissionRepository::class, \LaravelACL\Repositories\PermissionRepositoryEloquent::class);
        //:end-bindings:
    }
}
