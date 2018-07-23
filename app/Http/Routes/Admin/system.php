<?php
use Illuminate\Support\Facades\Input;

/*
    |--------------------------------------------------------------------------
    | 後台-系統相關功能
    |--------------------------------------------------------------------------        
*/

Route::group(['prefix' => '/game-admin/dashboard/system', 'middleware' => ['auth.admin']], function() {
       
    /*參數設定*/
    Route::group(['prefix' => '/parameter', 'middleware' => ['role:super-admin|master-admin|parameter-preview']], function() {
        //編輯
        Route::get('/', ['as' => 'admin.parameter.index', 'middleware' => ['role:master-admin|super-admin|parameter-preview'],'uses'=>'Admin\System\ParametersController@index']);
        //更新
        Route::put('/', ['as' => 'admin.parameter.update', 'middleware' => ['role:master-admin|super-admin|parameter-write'],'uses'=>'Admin\System\ParametersController@update']);
    });

    /*象棋參數設定*/
    Route::group(['prefix' => '/cn_chess_chip', 'middleware' => ['role:super-admin|master-admin|parameter-preview']], function() {
        //編輯
        Route::get('/', ['as' => 'admin.cn_chess_chip.index', 'middleware' => ['role:master-admin|super-admin|parameter-preview'],'uses'=>'Admin\System\CnChessChipsController@index']);
        //更新
        Route::put('/', ['as' => 'admin.cn_chess_chip.update', 'middleware' => ['role:master-admin|super-admin|parameter-write'],'uses'=>'Admin\System\CnChessChipsController@update']);
    });

    /*後台操作記錄*/
    Route::group(['prefix' => '/admin_activity', 'middleware' => ['role:super-admin|master-admin|admin-activity-preview']], function() {
        
        //列表
        Route::get('/{start?}/{end?}', ['as' => 'admin.admin_activity.index','uses'=>'Admin\System\AdminActivitiesController@index']);
        
    });

    /*會員登入記錄*/
    Route::group(['prefix' => '/login_record', 'middleware' => ['role:super-admin|master-admin|login-record-preview']], function() {
        
        //列表
        Route::get('/{start?}/{end?}', ['as' => 'admin.login_record.index','uses'=>'Admin\System\LoginRecordsController@index']);
        
    });

    /*排程記錄*/
    Route::group(['prefix' => '/schedule_record', 'middleware' => ['role:super-admin|master-admin|schedule-record-preview']], function() {
        
        //列表
        Route::get('/{start?}/{end?}/{name?}', ['as' => 'admin.schedule_record.index','uses'=>'Admin\System\ScheduleRecordsController@index']);
        
    });

    /*公司發紅包*/
    Route::group(['prefix' => '/company_transfer', 'middleware' => ['role:super-admin|master-admin|company-transfer-preview']], function() {
        
        //列表
        Route::get('/{start?}/{end?}', ['as' => 'admin.system.company_transfer.index','uses'=>'Admin\System\CompanyTransfersController@index']);
        //新增
        Route::get('/create', ['as' => 'admin.system.company_transfer.create','uses'=>'Admin\System\CompanyTransfersController@create']);
        //公司轉帳
        Route::post('/company', ['as' => 'admin.system.company_transfer.company_store','uses'=>'Admin\System\CompanyTransfersController@storeCompanyTransfer']);
        //會員轉帳
        Route::post('/member', ['as' => 'admin.system.company_transfer.member_store','uses'=>'Admin\System\CompanyTransfersController@storeMemberTransfer']);
        
    });

    /*轉帳紀錄*/
    Route::group(['prefix' => '/transfer_record', 'middleware' => ['role:super-admin|master-admin|transfer-record-preview']], function() {
        
        //列表
        Route::get('/{start?}/{end?}', ['as' => 'admin.system.transfer_record.index','uses'=>'Admin\System\TransferRecordsController@index']);
        
    });

    /*管理員*/
    Route::group(['prefix' => '/admin', 'middleware' => ['role:super-admin|master-admin']], function() {
        
        Route::get('/', ['as' => 'admin.admin.index','uses'=>'Admin\AdminsController@index']);
        Route::get('/create', ['as' => 'admin.admin.create','uses'=>'Admin\AdminsController@create']);
        Route::post('/', ['as' => 'admin.admin.store','uses'=>'Admin\AdminsController@store']);
        Route::get('/{id}/edit', ['as' => 'admin.admin.edit','uses'=>'Admin\AdminsController@edit']);
        Route::delete('/{id}', ['as' => 'admin.admin.destroy','uses'=>'Admin\AdminsController@destroy']);
        Route::put('/{id}', ['as' => 'admin.admin.update','uses'=>'Admin\AdminsController@update']);

        //權限
        Route::get('/permission/{user}', ['as' => 'admin.admin.permission','uses'=>'Admin\AdminsController@editPermission']);
        Route::put('/permission/{user}', ['as' => 'admin.admin.permission_edit','uses'=>'Admin\AdminsController@updatePermission']);

    });
   
    
});



