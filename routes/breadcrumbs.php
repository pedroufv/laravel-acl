<?php

Breadcrumbs::for('admin.home', function($breadcrumbs)
{
	$breadcrumbs->push(Lang::get('admin.home'), route('admin.home'));
});
// codigo maluco para gerar migalhas - por favor melhore
foreach(Route::getRoutes() as $route){
	if($route->getPrefix() == 'admin' AND $route->getName() != 'admin.home') {
		$name = explode('.', $route->getName());
		if($name[2] == 'index') {
			Breadcrumbs::for($route->getName(), function ($breadcrumbs, $route) use ($name){
				$breadcrumbs->parent('admin.home');
				//ucfirst($name[1])
				$breadcrumbs->push(Lang::get($route->getName()),route($route->getName()));
			});
		} else {
			Breadcrumbs::for($route->getName(), function ($breadcrumbs, $route)use ($name){
				$breadcrumbs->parent($name[0].".".$name[1].".index", Route::getRoutes()->getByName($name[0].".".$name[1].".index"));
				if($route->hasParameters()) {
					$breadcrumbs->push(Lang::get($route->getName()), route($route->getName(), $route->parameters()));
				} else {
					$breadcrumbs->push(Lang::get($route->getName()), route($route->getName()));
				}
			});
		}
	}
}