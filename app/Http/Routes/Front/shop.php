<?php
use Illuminate\Support\Facades\Input;
Route::pattern('id', '[0-9]+');
Route::pattern('start','[0-9]{4}-[0-9]{2}-[0-9]{2}');
Route::pattern('end','[0-9]{4}-[0-9]{2}-[0-9]{2}');
/*
    |--------------------------------------------------------------------------
    |  商城
    |--------------------------------------------------------------------------        
*/

Route::group(['prefix' => '/shop','middleware'=> ['auth','verify','web.status']], function() {

	/*線上儲值*/
	Route::group(['prefix' => '/charge'], function() {

	    //列表
	    Route::get('/{start?}/{end?}', ['as' => 'front.shop.charge.index','uses'=>'Front\Shop\ChargesController@index']);
	    
	    //新增
	    Route::post('/', ['as' => 'front.shop.charge.store','uses'=>'Front\Shop\ChargesController@store']);
	    
   		//刪除
	    Route::delete('/{id}', ['as' => 'front.shop.charge.destroy','uses'=>'Front\Shop\ChargesController@destroy']);
   
	});

	/*紅包群發列表*/
	Route::group(['prefix' => '/withdrawal'], function() {

	    //列表
	    Route::get('/{start?}/{end?}', ['as' => 'front.shop.withdrawal.index','uses'=>'Front\Shop\WithdrawalsController@index']);
	});


	//單一類別商品列表
	Route::get('/category/{id?}', ['as' => 'front.shop.category.index','uses'=>'Front\Shop\ProductsController@index']);

	/*商品資訊*/
	Route::group(['prefix' => '/product'], function() {

		//切換商品資訊入口
		Route::get('/show/{id}/{quantity_show?}', ['as' => 'front.shop.product.show','uses'=>'Front\Shop\ProductsController@show']);
		//購買商品
		Route::post('/buy', ['as' => 'front.shop.product.buy','uses'=>'Front\Shop\ProductsController@buy']);
	
		//推薦卡
		Route::get('/register_card/show/{id}/{quantity_show?}', ['as' => 'front.shop.product.register_card.show','uses'=>'Front\Shop\Product\RegisterCardsController@show']);
		
		//VIP卡
		Route::get('/member_card/show/{id}/{quantity_show?}', ['as' => 'front.shop.product.member_card.show','uses'=>'Front\Shop\Product\MemberCardsController@show']);
		
		//紅包卡
		Route::get('/account_transfer/show/{id}/{quantity_show?}', ['as' => 'front.shop.product.account_transfer.show','uses'=>'Front\Shop\Product\AccountTransfersController@show']);
		
		//娛樂幣
		Route::get('/share/show/{id}/{quantity_show?}', ['as' => 'front.shop.product.share.show','uses'=>'Front\Shop\Product\SharesController@show']);
		
		//專屬娛樂幣
		Route::get('/own_share/show/{id}/{quantity_show?}', ['as' => 'front.shop.product.own_share.show','uses'=>'Front\Shop\Product\OwnSharesController@show']);

		//拍賣卡
		Route::get('/auction/show/{id}/{quantity_show?}', ['as' => 'front.shop.product.auction.show','uses'=>'Front\Shop\Product\AuctionsController@show']);
		
	});

	/*使用商品*/
	Route::group(['prefix' => '/use'], function() {

		//使用導向
		Route::get('/{id}', ['as' => 'front.shop.use.redirect','uses'=>'Front\Shop\ProductsController@useRedirect']);

		/*使用推薦卡*/
		Route::group(['prefix' => '/register_card'], function() {

		    //推薦卡使用表單
		    Route::get('/{id}', ['as' => 'front.shop.use.register_card.index','uses'=>'Front\Shop\Product\RegisterCardsController@useIndex']);
		
		    //確認使用
		    Route::post('/', ['as' => 'front.shop.use.register_card.use','uses'=>'Front\Shop\Product\RegisterCardsController@useProcess']);
		    
		});

		/*使用VIP卡*/
		Route::group(['prefix' => '/member_card'], function() {
			//VIP卡使用表單
		    Route::get('/{id}', ['as' => 'front.shop.use.member_card.index','uses'=>'Front\Shop\Product\MemberCardsController@useIndex']);
		
		    //確認使用
		    Route::post('/', ['as' => 'front.shop.use.member_card.use','uses'=>'Front\Shop\Product\MemberCardsController@useProcess']);
		    
		});

		/*使用娛樂幣*/
		Route::group(['prefix' => '/share'], function() {
			//使用表單
		    Route::get('/{id}', ['as' => 'front.shop.use.share.index','uses'=>'Front\Shop\Product\SharesController@useIndex']);
		
		    //確認使用
		    Route::post('/', ['as' => 'front.shop.use.share.use','uses'=>'Front\Shop\Product\SharesController@useProcess']);
		    
		});

		/*使用專屬娛樂幣*/
		Route::group(['prefix' => '/own_share'], function() {
			//使用表單
		    Route::get('/{id}', ['as' => 'front.shop.use.own_share.index','uses'=>'Front\Shop\Product\OwnSharesController@useIndex']);
		
		    //確認使用
		    Route::post('/', ['as' => 'front.shop.use.own_share.use','uses'=>'Front\Shop\Product\OwnSharesController@useProcess']);
		    
		});

		/*使用紅包卡*/
		Route::group(['prefix' => '/account_transfer'], function() {
			//紅包卡使用表單
		    Route::get('/{id}', ['as' => 'front.shop.use.account_transfer.index','uses'=>'Front\Shop\Product\AccountTransfersController@useIndex']);
		
		    //確認使用
		   // Route::post('/', ['as' => 'front.shop.use.account_transfer.use','uses'=>'Front\Shop\Product\AccountTransfersController@useProcess']);
		    
		    //檢查會員帳號
		    Route::post('/check-user', ['as' => 'front.shop.use.account_transfer.check_user','uses'=>'Front\Shop\Product\AccountTransfersController@checkUsernameValid']);
		    
		    //輸入簡訊驗證碼頁面
			Route::post('/sms', ['as' => 'front.shop.use.account_transfer.sms','uses'=>'Front\Shop\Product\AccountTransfersController@smsIndex']);    
			//處理使用
			Route::post('/', ['as' => 'front.shop.use.account_transfer.use','uses'=>'Front\Shop\Product\AccountTransfersController@useProcess']);

		});

		/*使用拍賣卡*/
		Route::group(['prefix' => '/auction'], function() {
		    //確認使用
		    Route::post('/', ['as' => 'front.shop.use.auction.use','uses'=>'Front\Shop\Product\AuctionsController@useProcess']);
		    
		});
	});


	/*我得商品*/
	Route::group(['prefix' => '/my_product'], function() {
		//列表
		Route::get('/', ['as' => 'front.shop.my_product','uses'=>'Front\Shop\ProductBagsController@index']);


	});
	//商品取得紀錄
	Route::get('/transaction/{start?}/{end?}', ['as' => 'front.shop.transaction','uses'=>'Front\Shop\TransactionsController@index']);
	//商品使用紀錄
	Route::get('/product_use_record/{start?}/{end?}', ['as' => 'front.shop.product_use_record','uses'=>'Front\Shop\ProductUseRecordsController@index']);


	/*交易平台*/
	Route::group(['prefix' => '/share_transaction'], function() {
		//入口首頁
		Route::get('/', ['as' => 'front.shop.share_transaction.index','uses'=>'Front\Shop\ShareTransactionsController@index']);

		//我要拍賣
		Route::get('/sell', ['as' => 'front.shop.share_transaction.sell_index','uses'=>'Front\Shop\ShareTransactionsController@sellIndex']);

		//目前牌價
		Route::get('/current_price', ['as' => 'front.shop.share_transaction.current_price','uses'=>'Front\Shop\ShareTransactionsController@currentPrice']);

		//我的交易資訊-上架中
		Route::get('/my_on_the_shelf_transaction', ['as' => 'front.shop.share_transaction.on_the_shelf','uses'=>'Front\Shop\ShareTransactionsController@myOnTheShelfTransaction']);

		//我的交易資訊-拍賣歷史紀錄
		Route::get('/my_history_transaction', ['as' => 'front.shop.share_transaction.my_history','uses'=>'Front\Shop\ShareTransactionsController@myHistoryTransaction']);

		//我的交易資訊-購買紀錄
		Route::get('/buy_history_transaction', ['as' => 'front.shop.share_transaction.buy_history','uses'=>'Front\Shop\ShareTransactionsController@buyHistoryTransaction']);

		//所有拍賣資訊
		Route::get('/all_auction', ['as' => 'front.shop.share_transaction.all_auction','uses'=>'Front\Shop\ShareTransactionsController@allAuction']);

		//成交處理
		Route::post('/deal', ['as' => 'front.shop.share_transaction.deal','uses'=>'Front\Shop\ShareTransactionsController@dealTransaction']);

		//取消掛單
		Route::put('/cancel', ['as' => 'front.shop.share_transaction.cancel','uses'=>'Front\Shop\ShareTransactionsController@cancelTransaction']);

		//取得所有拍賣最便宜五筆
		Route::get('/cheapest_data/{limit?}', ['as' => 'front.shop.share_transaction.cheapest_data','uses'=>'Front\Shop\ShareTransactionsController@cheapestData']);

		//取得我的拍賣最便宜五筆
		Route::get('/my_cheapest_data/{limit?}', ['as' => 'front.shop.share_transaction.my_cheapest_data','uses'=>'Front\Shop\ShareTransactionsController@myCheapestData']);



	});

});
