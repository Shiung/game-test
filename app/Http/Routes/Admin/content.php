<?php
use Illuminate\Support\Facades\Input;

Route::pattern('id', '[0-9]+');
Route::pattern('start','[0-9]{4}-[0-9]{2}-[0-9]{2}');
Route::pattern('end','[0-9]{4}-[0-9]{2}-[0-9]{2}');
/*
    |--------------------------------------------------------------------------
    | 後台-網站內容相關功能
    |--------------------------------------------------------------------------        
*/

Route::group(['prefix' => '/game-admin/dashboard/content', 'middleware' => ['auth.admin']], function() {
       

    /*頁面管理*/
    Route::group(['prefix' => '/page', 'middleware' => ['role:super-admin|master-admin|page-preview']], function() {
        
        //列表
        Route::get('/', ['as' => 'admin.page.index','uses'=>'Admin\Content\PagesController@index']);
        //新增畫面
        Route::get('/create', ['as' => 'admin.page.create', 'middleware' => ['role:master-admin|super-admin|page-write'],'uses'=>'Admin\Content\PagesController@create']);
        //新增處理
        Route::post('/', ['as' => 'admin.page.store', 'middleware' => ['role:master-admin|super-admin|page-write'],'uses'=>'Admin\Content\PagesController@store']);
        //編輯
        Route::get('/{id}/edit', ['as' => 'admin.page.edit', 'middleware' => ['role:master-admin|super-admin|page-preview'],'uses'=>'Admin\Content\PagesController@edit']);
        //更新
        Route::put('/{id}', ['as' => 'admin.page.update', 'middleware' => ['role:master-admin|super-admin|page-write'],'uses'=>'Admin\Content\PagesController@update']);
        //刪除
        Route::delete('/{id}', ['as' => 'admin.page.destroy', 'middleware' => ['role:master-admin|super-admin|page-write'],'uses'=>'Admin\Content\PagesController@destroy']);
    });

    
    /*最新消息*/
    Route::group(['prefix' => '/news', 'middleware' => ['role:super-admin|master-admin|news-preview']], function() {
        
        //系統公告
        Route::get('/system-alert', ['as' => 'admin.news.system-alert.index','uses'=>'Admin\Content\NewsController@systemAlertIndex']);  

        Route::put('/system-alert', ['as' => 'admin.news.system-alert.update','uses'=>'Admin\Content\NewsController@systemAlertUpdate']);  

        //列表
        Route::get('/{start?}/{end?}', ['as' => 'admin.news.index','uses'=>'Admin\Content\NewsController@index']);
        //編輯
        Route::get('/{id}/edit', ['as' => 'admin.news.edit', 'middleware' => ['role:master-admin|super-admin|news-preview'],'uses'=>'Admin\Content\NewsController@edit']);
        //新增畫面
        Route::get('/create', ['as' => 'admin.news.create', 'middleware' => ['role:master-admin|super-admin|news-write'],'uses'=>'Admin\Content\NewsController@create']);
        //新增處理
        Route::post('/', ['as' => 'admin.news.store', 'middleware' => ['role:master-admin|super-admin|news-write'],'uses'=>'Admin\Content\NewsController@store']);
        //更新
        Route::put('/{id}', ['as' => 'admin.news.update', 'middleware' => ['role:master-admin|super-admin|news-write'],'uses'=>'Admin\Content\NewsController@update']);
        //刪除
        Route::delete('/{id}', ['as' => 'admin.news.destroy', 'middleware' => ['role:master-admin|super-admin|news-write'],'uses'=>'Admin\Content\NewsController@destroy']);
    });

    /*banner*/
    Route::group(['prefix' => '/banner', 'middleware' => ['role:super-admin|master-admin|banner-preview']], function() {
        //列表
        Route::get('/', ['as' => 'admin.banner.index','uses'=>'Admin\Content\BannersController@index']);
        //編輯
        Route::get('/{id}/edit', ['as' => 'admin.banner.edit', 'middleware' => ['role:master-admin|super-admin|banner-preview'],'uses'=>'Admin\Content\BannersController@edit']);
        //新增畫面
        Route::get('/create', ['as' => 'admin.banner.create', 'middleware' => ['role:master-admin|super-admin|banner-write'],'uses'=>'Admin\Content\BannersController@create']);
        //新增處理
        Route::post('/', ['as' => 'admin.banner.store', 'middleware' => ['role:master-admin|super-admin|banner-write'],'uses'=>'Admin\Content\BannersController@store']);
        //更新
        Route::put('/{id}', ['as' => 'admin.banner.update', 'middleware' => ['role:master-admin|super-admin|banner-write'],'uses'=>'Admin\Content\BannersController@update']);
        //刪除
        Route::delete('/{id}', ['as' => 'admin.banner.destroy', 'middleware' => ['role:master-admin|super-admin|banner-write'],'uses'=>'Admin\Content\BannersController@destroy']);
    });

    /*跑馬燈*/
    Route::group(['prefix' => '/marquee', 'middleware' => ['role:super-admin|master-admin|marquee-preview']], function() {
        //列表
        Route::get('/', ['as' => 'admin.marquee.index','uses'=>'Admin\Content\MarqueesController@index']);
        //編輯
        Route::get('/{id}/edit', ['as' => 'admin.marquee.edit', 'middleware' => ['role:master-admin|super-admin|marquee-preview'],'uses'=>'Admin\Content\MarqueesController@edit']);
        //新增畫面
        Route::get('/create', ['as' => 'admin.marquee.create', 'middleware' => ['role:master-admin|super-admin|marquee-write'],'uses'=>'Admin\Content\MarqueesController@create']);
        //新增處理
        Route::post('/', ['as' => 'admin.marquee.store', 'middleware' => ['role:master-admin|super-admin|marquee-write'],'uses'=>'Admin\Content\MarqueesController@store']);
        //更新
        Route::put('/{id}', ['as' => 'admin.marquee.update', 'middleware' => ['role:master-admin|super-admin|marquee-write'],'uses'=>'Admin\Content\MarqueesController@update']);
        //刪除
        Route::delete('/{id}', ['as' => 'admin.marquee.destroy', 'middleware' => ['role:master-admin|super-admin|marquee-write'],'uses'=>'Admin\Content\MarqueesController@destroy']);
    });

    /*留言板*/
    Route::group(['prefix' => '/board_message', 'middleware' => ['role:super-admin|master-admin|board-message-preview']], function() {

        //列表
        Route::get('/{start?}/{end?}', ['as' => 'admin.board_message.index','uses'=>'Admin\Content\BoardMessagesController@index']);
        //刪除
        Route::delete('/{id}', ['as' => 'admin.board_message.destroy', 'middleware' => ['role:master-admin|super-admin|board-message-write'],'uses'=>'Admin\Content\BoardMessagesController@destroy']);
    });
    
});



