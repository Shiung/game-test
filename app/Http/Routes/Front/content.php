<?php
use Illuminate\Support\Facades\Input;

/*
    |--------------------------------------------------------------------------
    |  一般頁面內容
    |--------------------------------------------------------------------------        
*/

/*公告*/
Route::group(['prefix' => '/news','middleware'=> ['auth','verify','web.status']], function() {

    //公告
    Route::get('/', ['as' => 'front.news.index','middleware'=> ['auth'],'uses'=>'Front\Content\NewsController@index']);
    Route::get('/{id}', ['as' => 'front.news.show','middleware'=> ['auth'],'uses'=>'Front\Content\NewsController@show']);
    
});

/*資訊頁面*/
Route::group(['prefix' => '/info','middleware'=> ['auth','verify','web.status']], function() {

    Route::get('/', ['as' => 'front.page.index','middleware'=> ['auth'],'uses'=>'Front\Content\PagesController@index']);
    Route::get('/{code}', ['as' => 'front.page.show','middleware'=> ['auth'],'uses'=>'Front\Content\PagesController@show']);
    
});

//彈跳視窗
Route::get('/system-alert', ['as' => 'front.system-alert','middleware'=> ['auth'],'uses'=>'Front\Content\NewsController@getSystemAlert']);

/*留言板*/
Route::group(['prefix' => '/board_message','middleware'=> ['auth','verify','web.status']], function() {

    Route::get('/{start?}/{end?}', ['as' => 'front.board_message.index','uses'=>'Front\Content\BoardMessagesController@index']);
    Route::post('/', ['as' => 'front.board_message.store','uses'=>'Front\Content\BoardMessagesController@store']);
    Route::put('/{id}', ['as' => 'front.board_message.update','uses'=>'Front\Content\BoardMessagesController@update']);
    Route::delete('/{id}', ['as' => 'front.board_message.destroy','uses'=>'Front\Content\BoardMessagesController@destroy']);
    
});