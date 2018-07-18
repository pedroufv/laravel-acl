<?php

namespace Ancora\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Route;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

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
            $this->middleware("permission:".
                preg_replace(
                    ['/data/', '/store/', '/update/'],
                    ['index', 'create', 'edit'],
                    Route::currentRouteName()
                )
            );
        }
    }
}
