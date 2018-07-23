<?php
use Illuminate\Support\Facades\Input;

Route::pattern('id', '[0-9]+');
Route::pattern('start','[0-9]{4}-[0-9]{2}-[0-9]{2}');
Route::pattern('end','[0-9]{4}-[0-9]{2}-[0-9]{2}');
/*
    |--------------------------------------------------------------------------
    | 後台- 會員相關功能
    |--------------------------------------------------------------------------        
*/

Route::group(['prefix' => '/game-admin/dashboard/member', 'middleware' => ['auth.admin']], function() {
         
    //列表
    Route::get('/', ['as' => 'admin.member.index', 'middleware' => ['role:master-admin|super-admin|member-preview'],'uses'=>'Admin\Member\MembersController@index']); 
    //瀏覽
    Route::get('/{id}/show', ['as' => 'admin.member.show', 'middleware' => ['role:master-admin|super-admin|member-preview'],'uses'=>'Admin\Member\MembersController@show']);
    //編輯
    Route::get('/{id}/edit', ['as' => 'admin.member.edit', 'middleware' => ['role:master-admin|super-admin|member-preview'],'uses'=>'Admin\Member\MembersController@edit']);
    //重設密碼
    Route::get('/{id}/reset_pwd', ['as' => 'admin.member.reset_pwd', 'middleware' => ['role:master-admin|super-admin|member-write'],'uses'=>'Admin\Member\MembersController@resetPwd']);
    
    //直接下線列表
    Route::get('/{id}/subs', ['as' => 'admin.member.subs', 'middleware' => ['role:master-admin|super-admin|member-preview'],'uses'=>'Admin\Member\MembersController@subIndex']);
    

    //更新密碼
    Route::put('/password/{id}', ['as' => 'admin.member.update_password', 'middleware' => ['role:master-admin|super-admin|member-write'],'uses'=>'Admin\Member\MembersController@updatePassword']);
    //更新登入權限
    Route::put('/login-permission/{id}', ['as' => 'admin.member.update_login_permission', 'middleware' => ['role:master-admin|super-admin|member-write'],'uses'=>'Admin\Member\MembersController@updateLoginPermission']);
    //更新
    Route::put('/{id}', ['as' => 'admin.member.update', 'middleware' => ['role:master-admin|super-admin|member-write'],'uses'=>'Admin\Member\MembersController@update']);
    
    /*社群組織圖*/
    Route::group(['prefix' => '/tree'], function() {

        //樹首頁
        Route::get('/{id}', ['as' => 'admin.member.tree','uses'=>'Admin\Member\TreeController@index']);
        Route::get('/search/{username}', ['as' => 'admin.member.tree_search','uses'=>'Admin\Member\TreeController@search']);

    });

    /*帳戶明細*/
    Route::group(['prefix' => '/account', 'middleware' => ['role:master-admin|super-admin|member-account-preview']], function() {

        //搜尋頁面
        Route::get('/', ['as' => 'admin.member.account.search','uses'=>'Admin\Member\AccountsController@search']);

        //搜尋明細結果
        Route::post('/', ['as' => 'admin.member.account.detail','uses'=>'Admin\Member\AccountsController@index']);

    });

    /*下注明細*/
    Route::group(['prefix' => '/bet_record', 'middleware' => ['role:master-admin|super-admin|member-betrecord-preview']], function() {

        //搜尋頁面
        Route::get('/', ['as' => 'admin.member.bet_record.search','uses'=>'Admin\Member\BetRecordsController@search']);

        //搜尋明細結果
        Route::post('/', ['as' => 'admin.member.bet_record.detail','uses'=>'Admin\Member\BetRecordsController@index']);

    });

    /*組織下注歷程*/
    Route::group(['prefix' => '/organization_bet_record', 'middleware' => ['role:master-admin|super-admin|organization-betrecord-preview']], function() {


        //搜尋頁面
        Route::get('/', ['as' => 'admin.member.organization_bet_record.search','uses'=>'Admin\Member\OrganizationBetRecordsController@search']);

        //總合
        Route::get('/total', ['as' => 'admin.member.organization_bet_record.index','uses'=>'Admin\Member\OrganizationBetRecordsController@index']);

        //搜尋明細結果
        Route::get('/detail/{user_id}', ['as' => 'admin.member.organization_bet_record.detail','uses'=>'Admin\Member\OrganizationBetRecordsController@detail']);
    }); 

    /*過戶申請列表*/
    Route::group(['prefix' => '/transfer_ownership_record', 'middleware' => ['role:super-admin|master-admin|transfer-ownership-record-preview']], function() {
        
        //列表
        Route::get('/{start?}/{end?}', ['as' => 'admin.member.transfer_ownership_record.index','uses'=>'Admin\Member\TransferOwnershipRecordsController@index']);
        //確認發放
        Route::put('/{id}', ['as' => 'admin.member.transfer_ownership_record.update', 'middleware' => ['role:master-admin|super-admin|transfer-ownership-record-write'],'uses'=>'Admin\Member\TransferOwnershipRecordsController@update']);
    });

    /*會員刪除申請列表*/
    Route::group(['prefix' => '/subs_delete_record', 'middleware' => ['role:super-admin|master-admin|subs-delete-record-preview']], function() {
        
        //列表
        Route::get('/{start?}/{end?}', ['as' => 'admin.member.subs_delete_record.index','uses'=>'Admin\Member\SubsDeleteRecordsController@index']);
        //確認發放
        Route::put('/{id}', ['as' => 'admin.member.subs_delete_record.update', 'middleware' => ['role:master-admin|super-admin|subs-delete-record-write'],'uses'=>'Admin\Member\SubsDeleteRecordsController@update']);
    });
});



