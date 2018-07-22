<?php

Route::get('/home', 'Web\HomeController@index')->name('home');

Route::get('/roles/data', 'Web\Admin\User\RolesController@data')->name('roles.data');
Route::resource('roles', 'Web\Admin\User\RolesController');

Route::get('/users/data', 'Web\Admin\User\UsersController@data')->name('users.data');
Route::resource('users', 'Web\Admin\User\UsersController');
