<?php

namespace Ancora\Providers;

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
        $this->app->bind(\Ancora\Repositories\UserRepository::class, \Ancora\Repositories\UserRepositoryEloquent::class);
        $this->app->bind(\Ancora\Repositories\RoleRepository::class, \Ancora\Repositories\RoleRepositoryEloquent::class);
        $this->app->bind(\Ancora\Repositories\PermissionRepository::class, \Ancora\Repositories\PermissionRepositoryEloquent::class);
        //:end-bindings:
    }
}
