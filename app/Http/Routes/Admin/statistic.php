<?php
use Illuminate\Support\Facades\Input;
Route::pattern('id', '[0-9]+');
Route::pattern('start','[0-9]{4}-[0-9]{2}-[0-9]{2}');
Route::pattern('end','[0-9]{4}-[0-9]{2}-[0-9]{2}');
/*
    |--------------------------------------------------------------------------
    | 後台-統計相關功能
    |--------------------------------------------------------------------------        
*/

Route::group(['prefix' => '/game-admin/dashboard/statistic', 'middleware' => ['auth.admin','role:super-admin|master-admin|statistic-preview']], function() {
       

    /*商城營收*/
    Route::group(['prefix' => '/shop_revenue'], function() {
        
        //列表
        Route::get('/summary/{start?}/{end?}/{period?}', ['as' => 'admin.statistic.shop_revenue.summary','uses'=>'Admin\Statistic\ShopRevenuesController@summary']);
        //會員列表
        Route::get('/members/{start}/{end}', ['as' => 'admin.statistic.shop_revenue.members','uses'=>'Admin\Statistic\ShopRevenuesController@members']);
        //明細
        Route::get('/detail/{id}/{start}/{end}', ['as' => 'admin.statistic.shop_revenue.detail','uses'=>'Admin\Statistic\ShopRevenuesController@detail']);
        
    });

    /*禮券支出*/
    Route::group(['prefix' => '/manage_account'], function() {
        
        //列表
        Route::get('/summary/{start?}/{end?}/{period?}', ['as' => 'admin.statistic.manage_account.summary','uses'=>'Admin\Statistic\ManageAccountsController@summary']);
        //會員列表
        Route::get('/members/{start}/{end}', ['as' => 'admin.statistic.manage_account.members','uses'=>'Admin\Statistic\ManageAccountsController@members']);
        //明細
        Route::get('/detail/{id}/{start}/{end}', ['as' => 'admin.statistic.manage_account.detail','uses'=>'Admin\Statistic\ManageAccountsController@detail']);
        
    });

    /*紅利支出*/
    Route::group(['prefix' => '/interest_account'], function() {
        
        //列表
        Route::get('/summary/{start?}/{end?}/{period?}', ['as' => 'admin.statistic.interest_account.summary','uses'=>'Admin\Statistic\InterestAccountsController@summary']);
        //會員列表
        Route::get('/members/{start}/{end}', ['as' => 'admin.statistic.interest_account.members','uses'=>'Admin\Statistic\InterestAccountsController@members']);
        //明細
        Route::get('/detail/{id}/{start}/{end}', ['as' => 'admin.statistic.interest_account.detail','uses'=>'Admin\Statistic\InterestAccountsController@detail']);
        
    });

    /*金幣增減*/
    Route::group(['prefix' => '/cash_account'], function() {
        
        //列表
        Route::get('/summary/{start?}/{end?}/{period?}', ['as' => 'admin.statistic.cash_account.summary','uses'=>'Admin\Statistic\CashAccountsController@summary']);
        //會員列表
        Route::get('/members/{start}/{end}', ['as' => 'admin.statistic.cash_account.members','uses'=>'Admin\Statistic\CashAccountsController@members']);
        //明細
        Route::get('/detail/{id}/{start}/{end}', ['as' => 'admin.statistic.cash_account.detail','uses'=>'Admin\Statistic\CashAccountsController@detail']);
        
    });


   
    
});



