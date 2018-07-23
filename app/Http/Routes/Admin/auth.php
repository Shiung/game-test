<?php
use Illuminate\Support\Facades\Input;

/*
    |--------------------------------------------------------------------------
    |  後台登入驗證
    |--------------------------------------------------------------------------        
*/
//後台登入驗證
Route::group(['prefix' => '/game-admin'], function() {
    
    Route::group(['prefix' => '/auth'], function() {

        //登入頁
        Route::get('/login', ['as' => 'admin.login.index','uses'=>'Admin\AuthController@getLogin']);
        
        //登入處理
        Route::post('/login', ['as' => 'admin.login.process','uses'=>'Admin\AuthController@login']);
        
        //登出
        Route::get('/logout', ['as' => 'admin.logout.process','uses'=>'Admin\AuthController@logout']);

    });
});
