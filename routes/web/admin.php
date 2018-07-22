<?php

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/roles/data', 'Admin\User\RolesController@data')->name('roles.data');
Route::resource('roles', 'Admin\User\RolesController');

Route::get('/users/data', 'Admin\User\UsersController@data')->name('users.data');
Route::resource('users', 'Admin\User\UsersController');
