<?php

namespace LaravelACL\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class TopMenu
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            \Menu::make('topMenu', function($menu) {



                if (Auth::user()->can('admin.users.index') OR Auth::user()->can('admin.roles.index')) {
                    $title = __('admin.config');
                    $menu->add($title);

                    if (Auth::user()->can('admin.users.index'))
                        $menu->get(str_slug($title))->add(__('general.users'), array('route' => 'admin.users.index'));

                    if (Auth::user()->can('admin.roles.index'))
                        $menu->get(str_slug($title))->add(__('general.roles'), array('route' => 'admin.roles.index'));

                    if ($menu->get(str_slug($title))->children()->contains('link.isActive', true))
                        $menu->get(str_slug($title))->active();
                }


            });
        }

        return $next($request);
    }
}
