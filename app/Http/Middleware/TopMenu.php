<?php

namespace Ancora\Http\Middleware;

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
                    $menu->add('Configurações de Usuários');

                    if (Auth::user()->can('admin.users.index'))
                        $menu->get('configuracoesDeUsuarios')->add('Usuarios', array('route' => 'admin.users.index'));

                    if (Auth::user()->can('admin.roles.index'))
                        $menu->get('configuracoesDeUsuarios')->add('Grupos', array('route' => 'admin.roles.index'));
                }
            });
        }

        return $next($request);
    }
}
