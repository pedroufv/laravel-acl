<?php

Route::post('login', 'Api\AuthController@login')->name('login');
Route::post('logout', 'Api\AuthController@logout')->name('logout');
Route::post('refresh', 'Api\AuthController@refresh')->name('refresh');
Route::get('me', 'Api\AuthController@me')->name('me');