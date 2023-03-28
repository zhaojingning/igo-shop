<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', 'PagesController@root')->name('root');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// 启用邮箱验证相关的路由（验证邮箱页面，重发验证邮件页面等）
Auth::routes(['verify' => true]);

// auth 中间件代表需要登录，verified中间件代表需要经过预想认证
Route::group(['middleware' => ['auth', 'verified']], function() {
	Route::get('user_addresses', 'UserAddressesController@index')->name('user_addresses.index');
});
