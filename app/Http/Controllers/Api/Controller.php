<?php

namespace LaravelACL\Http\Controllers\Api;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Route;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @SWG\Swagger(basePath="/api",
     *      @SWG\Info(title="LaravelACL", version="0.0.1")
     * )
     */

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->addMiddlewarePermission();
    }

    /**
     *  add middleware permission by route name
     */
    private function addMiddlewarePermission()
    {
        if (Route::currentRouteName()) {
            $this->middleware("permission:admin.".
                preg_replace(
                    ['/data/', '/store/', '/update/'],
                    ['index', 'create', 'edit'],
                    Route::currentRouteName()
                )
            );
        }
    }
}
