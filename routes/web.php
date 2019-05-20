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
//后台页面
Route::get('/', 'Admin\IndexController@index');

//商品管理
Route::any('/goods/add', 'Goods\GoodsController@addGoods');

//属性查询
Route::any('/attr/basic/select', 'Goods\GoodsController@selectBasicAttr');
Route::any('/attr/sale/select', 'Goods\GoodsController@selectSaleAttr');

//登录
Route::get('/dologin', 'Login\LoginController@login');
Route::post('/logindo', 'Login\LoginController@doLogin');
//注册
Route::get('/doregister', 'Login\LoginController@register');
Route::post('/registerdo', 'Login\LoginController@doRegister');
//退出
Route::get('/quit', 'Login\LoginController@quit');