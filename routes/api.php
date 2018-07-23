<?php

Route::post('login', 'Api\AuthController@login')->name('login');
Route::post('logout', 'Api\AuthController@logout')->name('logout');
Route::post('refresh_token', 'Api\AuthController@refresh_token')->name('refresh_token');
Route::get('me', 'Api\AuthController@me')->name('me');