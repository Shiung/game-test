<?php
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;

/*
    |--------------------------------------------------------------------------
    | 這個route主要放網站入口、token相關、維修畫面
    |--------------------------------------------------------------------------        
*/

//前台首頁
Route::get('/', ['as' => 'front.index','middleware'=> ['auth','verify','web.status'],'uses'=>'Front\DashboardController@index']);

//後台首頁
Route::get('/game-admin', ['as' => 'admin.index','middleware'=> ['auth.admin'],'uses'=>'Admin\DashboardController@index']);

//維修說明畫面
Route::get('/maintenance', ['as' => 'front.maintenance','uses'=>'Front\DashboardController@maintenance']);

/*jwt token*/

//取得管理員token
Route::get('/admin-token', ['as' => 'admin.token','uses'=>'TokenController@getAdminToken']);
//取得會員token
Route::get('/member-token', ['as' => 'member.token','uses'=>'TokenController@getMemberToken']);
//更新token
Route::post('/refresh-token', ['as' => 'r-token','uses'=>'TokenController@refreshToken']);

//更新csrf token
Route::get('refresh-csrf', function(){
    return csrf_token();
});

