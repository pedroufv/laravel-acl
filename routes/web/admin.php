<?php

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('permissions', 'User\PermissionsController');

Route::resource('roles', 'User\RolesController');

Route::resource('users', 'User\UsersController');