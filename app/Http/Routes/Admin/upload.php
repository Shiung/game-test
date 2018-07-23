<?php
use Illuminate\Support\Facades\Input;

/*
    |--------------------------------------------------------------------------
    | 後台-圖片管理器
    |--------------------------------------------------------------------------        
*/

Route::group(['prefix' => '/game-admin', 'middleware' => ['auth.admin']], function() {
    
    
    /*文件管理*/  
    Route::group(['prefix' => '/upload', 'middleware' => ['auth.admin']], function() {

        Route::get('/{field_name?}/{image_part?}', ['as' => 'admin.file_manager.index','uses'=> 'Admin\UploadController@index']);
        Route::post('/file', ['as' => 'admin.file.upload','uses'=> 'Admin\UploadController@uploadFile']);
        Route::delete('/file',  ['as' => 'admin.file.delete','uses'=>'Admin\UploadController@deleteFile']);
        Route::post('/folder',  ['as' => 'admin.folder.create','uses'=>'Admin\UploadController@createFolder']);
        Route::delete('/folder',  ['as' => 'admin.folder.delete','uses'=>'Admin\UploadController@deleteFolder']);

    });  
});



