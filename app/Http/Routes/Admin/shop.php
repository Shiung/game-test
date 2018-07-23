<?php
use Illuminate\Support\Facades\Input;

Route::pattern('id', '[0-9]+');
Route::pattern('start','[0-9]{4}-[0-9]{2}-[0-9]{2}');
Route::pattern('end','[0-9]{4}-[0-9]{2}-[0-9]{2}');
/*
    |--------------------------------------------------------------------------
    | 後台-商城相關功能
    |--------------------------------------------------------------------------        
*/

Route::group(['prefix' => '/game-admin/dashboard/shop', 'middleware' => ['auth.admin']], function() {
       
    /*線上儲值購買列表*/
    Route::group(['prefix' => '/charge', 'middleware' => ['role:super-admin|master-admin|charge-preview']], function() {
        
        //列表
        Route::get('/{start?}/{end?}', ['as' => 'admin.charge.index','uses'=>'Admin\Shop\ChargesController@index']);
        //確認發放
        Route::put('/{id}', ['as' => 'admin.charge.update', 'middleware' => ['role:master-admin|super-admin|charge-write'],'uses'=>'Admin\Shop\ChargesController@update']);
    });

    /*紅包群發列表*/
    Route::group(['prefix' => '/withdrawal', 'middleware' => ['role:super-admin|master-admin|withdrawal-preview']], function() {
        
        //列表
        Route::get('/{start?}/{end?}', ['as' => 'admin.withdrawal.index','uses'=>'Admin\Shop\WithdrawalsController@index']);
        //確認發縙
        Route::put('/{id}', ['as' => 'admin.withdrawal.update', 'middleware' => ['role:master-admin|super-admin|withdrawal-write'],'uses'=>'Admin\Shop\WithdrawalsController@update']);
    });

    /*商品管理*/
    Route::group(['prefix' => '/product', 'middleware' => ['role:super-admin|master-admin|product-preview']], function() {
        
        Route::get('/{id}', ['as' => 'admin.product.show','uses'=>'Admin\Shop\ProductsController@show']);
            
        /*VIP卡管理*/
        Route::group(['prefix' => '/member_card'], function() {
            
            //列表
            Route::get('/', ['as' => 'admin.shop.product.member_card.index','uses'=>'Admin\Shop\Product\MemberCardsController@index']);
            //顯示資訊
            Route::get('/{id}', ['as' => 'admin.shop.product.member_card.show','uses'=>'Admin\Shop\Product\MemberCardsController@show']);
            //編輯
            Route::get('/{id}/edit', ['as' => 'admin.shop.product.member_card.edit','uses'=>'Admin\Shop\Product\MemberCardsController@edit']);
            //新增頁面
            Route::get('/create', ['as' => 'admin.shop.product.member_card.create','uses'=>'Admin\Shop\Product\MemberCardsController@create']);
            //新增
            Route::post('/', ['as' => 'admin.shop.product.member_card.store', 'middleware' => ['role:super-admin|master-admin|product-write'],'uses'=>'Admin\Shop\Product\MemberCardsController@store']);
            
            //更新上下架狀態
            Route::put('/change-status/{id}', ['as' => 'admin.shop.product.member_card.status', 'middleware' => ['role:master-admin|super-admin|product-write'],'uses'=>'Admin\Shop\Product\MemberCardsController@changeStatus']);
            //更新資訊
            Route::put('/info/{id}', ['as' => 'admin.shop.product.member_card.info_update', 'middleware' => ['role:master-admin|super-admin|product-write'],'uses'=>'Admin\Shop\Product\MemberCardsController@update']);
        
        });

        /*推薦卡管理*/
        Route::group(['prefix' => '/register_card'], function() {
            
            //列表
            Route::get('/', ['as' => 'admin.shop.product.register_card.index','uses'=>'Admin\Shop\Product\RegisterCardsController@index']);
            //顯示資訊
            Route::get('/{id}', ['as' => 'admin.shop.product.register_card.show','uses'=>'Admin\Shop\Product\RegisterCardsController@show']);
            //編輯
            Route::get('/{id}/edit', ['as' => 'admin.shop.product.register_card.edit','uses'=>'Admin\Shop\Product\RegisterCardsController@edit']);
            
            //新增頁面
            Route::get('/create', ['as' => 'admin.shop.product.register_card.create','uses'=>'Admin\Shop\Product\RegisterCardsController@create']);
            //新增
            Route::post('/', ['as' => 'admin.shop.product.register_card.store', 'middleware' => ['role:super-admin|master-admin|product-write'],'uses'=>'Admin\Shop\Product\RegisterCardsController@store']);
            
            //更新上下架狀態
            Route::put('/change-status/{id}', ['as' => 'admin.shop.product.register_card.status', 'middleware' => ['role:master-admin|super-admin|product-write'],'uses'=>'Admin\Shop\Product\RegisterCardsController@changeStatus']);
            //更新資訊
            Route::put('/info/{id}', ['as' => 'admin.shop.product.register_card.info_update', 'middleware' => ['role:master-admin|super-admin|product-write'],'uses'=>'Admin\Shop\Product\RegisterCardsController@update']);
        
        });

        /*紅包卡管理*/
        Route::group(['prefix' => '/account_transfer'], function() {
            
            //列表
            Route::get('/', ['as' => 'admin.shop.product.account_transfer.index','uses'=>'Admin\Shop\Product\AccountTransfersController@index']);
            //顯示資訊
            Route::get('/{id}', ['as' => 'admin.shop.product.account_transfer.show','uses'=>'Admin\Shop\Product\AccountTransfersController@show']);
            //編輯頁面
            Route::get('/{id}/edit', ['as' => 'admin.shop.product.account_transfer.edit','uses'=>'Admin\Shop\Product\AccountTransfersController@edit']);            
            //新增頁面
            Route::get('/create', ['as' => 'admin.shop.product.account_transfer.create','uses'=>'Admin\Shop\Product\AccountTransfersController@create']);
            //新增
            Route::post('/', ['as' => 'admin.shop.product.account_transfer.store', 'middleware' => ['role:super-admin|master-admin|product-write'],'uses'=>'Admin\Shop\Product\AccountTransfersController@store']);
            
            //更新上下架狀態
            Route::put('/change-status/{id}', ['as' => 'admin.shop.product.account_transfer.status', 'middleware' => ['role:master-admin|super-admin|product-write'],'uses'=>'Admin\Shop\Product\AccountTransfersController@changeStatus']);
            //更新資訊
            Route::put('/info/{id}', ['as' => 'admin.shop.product.account_transfer.info_update', 'middleware' => ['role:master-admin|super-admin|product-write'],'uses'=>'Admin\Shop\Product\AccountTransfersController@update']);
        
        });


        /*娛樂幣*/
        Route::group(['prefix' => '/share'], function() {
            
            //列表
            Route::get('/', ['as' => 'admin.shop.product.share.index','uses'=>'Admin\Shop\Product\SharesController@index']);
            //顯示資訊
            Route::get('/{id}', ['as' => 'admin.shop.product.share.show','uses'=>'Admin\Shop\Product\SharesController@show']);
            //更新
            Route::put('/', ['as' => 'admin.shop.product.share.store', 'middleware' => ['role:super-admin|master-admin|product-write'],'uses'=>'Admin\Shop\Product\SharesController@update']);
            
            //更新上下架狀態
            Route::put('/change-status/{id}', ['as' => 'admin.shop.product.share.status', 'middleware' => ['role:master-admin|super-admin|product-write'],'uses'=>'Admin\Shop\Product\SharesController@changeStatus']);
        });

        /*專屬娛樂幣*/
        Route::group(['prefix' => '/own_share'], function() {
            
            //列表
            Route::get('/', ['as' => 'admin.shop.product.own_share.index','uses'=>'Admin\Shop\Product\OwnSharesController@index']);
            //顯示資訊
            Route::get('/{id}', ['as' => 'admin.shop.product.own_share.show','uses'=>'Admin\Shop\Product\OwnSharesController@show']);
            //更新
            Route::put('/', ['as' => 'admin.shop.product.own_share.store', 'middleware' => ['role:super-admin|master-admin|product-write'],'uses'=>'Admin\Shop\Product\OwnSharesController@update']);
            
            //更新上下架狀態
            Route::put('/change-status/{id}', ['as' => 'admin.shop.product.own_share.status', 'middleware' => ['role:master-admin|super-admin|product-write'],'uses'=>'Admin\Shop\Product\OwnSharesController@changeStatus']);
        });

        /*拍賣卡管理*/
        Route::group(['prefix' => '/auction'], function() {
            
            //列表
            Route::get('/', ['as' => 'admin.shop.product.auction.index','uses'=>'Admin\Shop\Product\AuctionsController@index']);
            //顯示資訊
            Route::get('/{id}', ['as' => 'admin.shop.product.auction.show','uses'=>'Admin\Shop\Product\AuctionsController@show']);
            //編輯頁面
            Route::get('/{id}/edit', ['as' => 'admin.shop.product.auction.edit','uses'=>'Admin\Shop\Product\AuctionsController@edit']);            
            //新增頁面
            Route::get('/create', ['as' => 'admin.shop.product.auction.create','uses'=>'Admin\Shop\Product\AuctionsController@create']);
            //新增
            Route::post('/', ['as' => 'admin.shop.product.auction.store', 'middleware' => ['role:super-admin|master-admin|product-write'],'uses'=>'Admin\Shop\Product\AuctionsController@store']);
            
            //更新上下架狀態
            Route::put('/change-status/{id}', ['as' => 'admin.shop.product.auction.status', 'middleware' => ['role:master-admin|super-admin|product-write'],'uses'=>'Admin\Shop\Product\AuctionsController@changeStatus']);
            //更新資訊
            Route::put('/info/{id}', ['as' => 'admin.shop.product.auction.info_update', 'middleware' => ['role:master-admin|super-admin|product-write'],'uses'=>'Admin\Shop\Product\AuctionsController@update']);
        
        });
    });

    //商品取得紀錄
    Route::get('/transaction/{category_id?}/{start?}/{end?}', ['as' => 'admin.shop.transaction', 'middleware' => ['role:super-admin|master-admin|transaction-preview'],'uses'=>'Admin\Shop\TransactionsController@index']);
    //商品使用紀錄
    Route::get('/product_use_record/{start?}/{end?}', ['as' => 'admin.shop.product_use_record', 'middleware' => ['role:super-admin|master-admin|product-use-record-preview'],'uses'=>'Admin\Shop\ProductUseRecordsController@index']);

    /*贈送商品*/
    Route::group(['prefix' => '/give_product' , 'middleware' => ['role:super-admin|master-admin|give-product-preview']], function() {
        
        //列表
        Route::get('/{start?}/{end?}', ['as' => 'admin.shop.give_product.index','uses'=>'Admin\Shop\GiveProductsController@index']);
        //新增頁面
        Route::get('/create', ['as' => 'admin.shop.give_product.create', 'middleware' => ['role:super-admin|master-admin|give-product-write'],'uses'=>'Admin\Shop\GiveProductsController@create']);
        //新增
        Route::post('/', ['as' => 'admin.shop.give_product.store', 'middleware' => ['role:super-admin|master-admin|give-product-write'],'uses'=>'Admin\Shop\GiveProductsController@store']);
    });

    //娛樂幣掛單紀錄
    Route::get('/share_transaction/{status?}/{start?}/{end?}', ['as' => 'admin.shop.share_transaction.index', 'middleware' => ['role:super-admin|master-admin|share-transaction-preview'],'uses'=>'Admin\Shop\ShareTransactionsController@index']);

    
});

/*娛樂幣發行*/
Route::group(['prefix' => '/game-admin/dashboard/share_record' , 'middleware' => ['role:super-admin|master-admin|share-preview']], function() {
    
    //列表
    Route::get('/{start?}/{end?}', ['as' => 'admin.share_record.index','uses'=>'Admin\Shop\ShareRecordsController@index']);
    //新增
    Route::post('/', ['as' => 'admin.share_record.store', 'middleware' => ['role:super-admin|master-admin|share-write'],'uses'=>'Admin\Shop\ShareRecordsController@addRecord']);
});

