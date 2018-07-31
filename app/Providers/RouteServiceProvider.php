<?php

namespace LaravelACL\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'LaravelACL\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Route::bind('user', function ($id) {
            return \LaravelACL\Entities\User::withTrashed()->find($id);
        });

        Route::bind('role', function ($id) {
            return \LaravelACL\Entities\Role::withTrashed()->find($id);
        });
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        $route = Route::middleware('web')->namespace($this->namespace);

        // common
        $route->group(base_path('routes/web.php'));

        $route->prefix('admin')->as('admin.')->group(base_path('routes/web/admin.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        $route = Route::prefix('api')->middleware(['api','cors'])->namespace($this->namespace);

        // common
        $route->group(base_path('routes/api.php'));

        $route->middleware(['jwt.auth'])->group(base_path('routes/api/admin.php'));
    }
}
