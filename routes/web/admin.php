<?php

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('permissions', 'User\PermissionsController');

Route::resource('roles', 'User\RolesController');

Route::get('/users/data', 'User\UsersController@data')->name('users.data');
Route::resource('users', 'User\UsersController');
