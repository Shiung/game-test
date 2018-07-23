<?php
use Illuminate\Support\Facades\Input;
Route::pattern('id', '[0-9]+');
Route::pattern('start','[0-9]{4}-[0-9]{2}-[0-9]{2}');
Route::pattern('end','[0-9]{4}-[0-9]{2}-[0-9]{2}');
/*
    |--------------------------------------------------------------------------
    | 後台-下載相關功能
    |--------------------------------------------------------------------------        
*/

Route::group(['prefix' => '/game-admin/dashboard/download', 'middleware' => ['auth.admin']], function() {
       

    //會員明細總表
    Route::get('/account/{start?}/{end?}', ['as' => 'admin.download.account','uses'=>'Admin\Member\AccountsController@download']);
        


   
    
});



