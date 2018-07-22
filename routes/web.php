<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

$this->get('login', 'Web\Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Web\Auth\LoginController@login');
$this->post('logout', 'Web\Auth\LoginController@logout')->name('logout');

// Password Reset Routes...
$this->get('password/reset', 'Web\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
$this->post('password/email', 'Web\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
$this->get('password/reset/{token}', 'Web\Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Web\Auth\ResetPasswordController@reset');
