<?php
use Illuminate\Support\Facades\Input;

/*
    |--------------------------------------------------------------------------
    |  會員中心、簽到中心
    |--------------------------------------------------------------------------        
*/
//會員專區首頁 
Route::get('/member-center', ['as' => 'front.member.index','middleware'=> ['auth','verify','web.status'],'uses'=>'Front\DashboardController@memberCenter']);

//第一次身份驗證
Route::group(['prefix' => '/verify','middleware'=> ['web.status']], function() {

	//檢查手機是否可用
    Route::post('/phone-check', ['as' => 'front.verify.phone_check','middleware'=> ['auth'],'uses'=>'Front\Member\VerifyController@phoneCheck']);

    //第一次重設密碼
    Route::get('/first-reset-pwd', ['as' => 'front.verify.first_reset_pwd.index','middleware'=> ['auth'],'uses'=>'Front\Member\VerifyController@firstResetPwdIndex']);
    Route::post('/first-reset-pwd', ['as' => 'front.verify.first_reset_pwd.reset','middleware'=> ['auth'],'uses'=>'Front\Member\VerifyController@resetPwdProcess']);
    
    //同意使用者規範
    Route::get('/agreement', ['as' => 'front.verify.agreement.index','middleware'=> ['auth'],'uses'=>'Front\Member\VerifyController@agreementIndex']);
    Route::post('/agreement', ['as' => 'front.verify.agreement.confirm','middleware'=> ['auth'],'uses'=>'Front\Member\VerifyController@agreementProcess']);
    

    //輸入手機號碼
    Route::get('/phone', ['as' => 'front.verify.phone','middleware'=> ['auth'],'uses'=>'Front\Member\VerifyController@phoneIndex']);
    //輸入簡訊驗證碼頁面
    Route::post('/sms', ['as' => 'front.verify.sms','middleware'=> ['auth'],'uses'=>'Front\Member\VerifyController@smsIndex']);
    //產生簡訊驗證碼
    Route::post('/sms-create', ['as' => 'front.verify.sms_create','middleware'=> ['auth'],'uses'=>'Front\Member\VerifyController@createSmsVerify']);
    //簡訊驗證處理
    Route::post('/sms-auth', ['as' => 'front.verify.sms_auth','middleware'=> ['auth'],'uses'=>'Front\Member\VerifyController@smsAuth']);

});

/*會員專區*/
Route::group(['prefix' => '/member','middleware'=> ['auth','verify','web.status']], function() {

	//查詢帳號是否重複
	Route::get('/username-exist', ['as' => 'front.member.username_exist','uses'=>'Front\Member\UserController@checkUsernameExist']);
	
	//瀏覽個人資訊
	Route::get('/info', ['as' => 'front.member.info','uses'=>'Front\Member\UserController@info']);

	//編輯個人資訊
	Route::get('/edit', ['as' => 'front.member.info_edit','uses'=>'Front\Member\UserController@editInfo']);
	//輸入個人資料簡訊驗證碼頁面
	Route::post('/info-sms', ['as' => 'front.member.info_sms','uses'=>'Front\Member\UserController@infoSmsIndex']);    
	//處理更新個人資料
	Route::put('/info', ['as' => 'front.member.info_update','uses'=>'Front\Member\UserController@updateInfo']);  
	
	//重設密碼
	Route::get('/reset-pwd', ['as' => 'front.member.reset_pwd','uses'=>'Front\Member\UserController@editPwd']);
	//輸入重設密碼簡訊驗證碼頁面
	Route::post('/reset-pwd-sms', ['as' => 'front.member.pwd_sms','uses'=>'Front\Member\UserController@pwdSmsIndex']);    
	//處理重設密碼
	Route::post('/reset-pwd', ['as' => 'front.member.reset_pwd_update','uses'=>'Front\Member\UserController@resetPwdProcess']);

	/*社群結構樹*/
	Route::group(['prefix' => '/tree'], function() {

		//樹首頁
		Route::get('/', ['as' => 'front.member.tree','uses'=>'Front\Member\TreeController@index']);
		Route::get('/search/{username}', ['as' => 'front.member.tree_search','uses'=>'Front\Member\TreeController@search']);

	});

	//直接推薦下線列表
	Route::get('/subs', ['as' => 'front.member.subs','uses'=>'Front\Member\UserController@subs']);
	//下線資訊
	Route::get('/sub-info/{id}', ['as' => 'front.member.sub_info','uses'=>'Front\Member\UserController@subInfo']);


	//過戶申請
	Route::group(['prefix' => '/transfer_ownership_record'], function() {

		Route::get('/', ['as' => 'front.member.transfer_ownership_record.index','uses'=>'Front\Member\TransferOwnershipRecordsController@index']);
		//輸入簡訊驗證碼頁面
		Route::post('/sms', ['as' => 'front.member.transfer_ownership_record.sms','uses'=>'Front\Member\TransferOwnershipRecordsController@smsIndex']);    
		//處理使用
		Route::post('/', ['as' => 'front.member.transfer_ownership_record.use','uses'=>'Front\Member\TransferOwnershipRecordsController@process']);

	});

	//好友刪除申請
	Route::group(['prefix' => '/subs_delete_record'], function() {
		//取得好友基本資訊
		Route::get('/sub_info', ['as' => 'front.member.subs_delete_record.sub_info','uses'=>'Front\Member\SubsDeleteRecordsController@getSubInfoData']);
		//申請畫面
		Route::get('/create', ['as' => 'front.member.subs_delete_record.create','uses'=>'Front\Member\SubsDeleteRecordsController@create']);
		
		Route::get('/', ['as' => 'front.member.subs_delete_record.index','uses'=>'Front\Member\SubsDeleteRecordsController@index']);
		//處理使用
		Route::post('/', ['as' => 'front.member.subs_delete_record.use','uses'=>'Front\Member\SubsDeleteRecordsController@process']);

	});
});

/*簽到中心*/
Route::group(['prefix' => '/checkin','middleware'=> ['auth','verify','web.status']], function() {

	//列表
	Route::get('/', ['as' => 'front.checkin.index','uses'=>'Front\Member\AccountReceiveRecordsController@index']);

	//領取
	Route::post('/', ['as' => 'front.checkin.receive','uses'=>'Front\Member\AccountReceiveRecordsController@receive']);    


});		


/*帳戶明細*/
Route::group(['prefix' => '/account','middleware'=> ['auth','verify','web.status']], function() {


	//搜尋頁面
	Route::get('/', ['as' => 'front.account.search','uses'=>'Front\Member\AccountsController@search']);

	//搜尋明細結果
	Route::post('/', ['as' => 'front.account.detail','uses'=>'Front\Member\AccountsController@index']);


});	

/*下注明細*/
Route::group(['prefix' => '/bet_record','middleware'=> ['auth','verify','web.status']], function() {


	//搜尋頁面
	Route::get('/', ['as' => 'front.bet_record.search','uses'=>'Front\Member\BetRecordsController@search']);

	//搜尋明細結果
	Route::post('/', ['as' => 'front.bet_record.detail','uses'=>'Front\Member\BetRecordsController@index']);


});	

/*組織下注歷程*/
Route::group(['prefix' => '/organization_bet_record','middleware'=> ['auth','verify','web.status']], function() {


	//搜尋頁面
	Route::get('/', ['as' => 'front.organization_bet_record.search','uses'=>'Front\Member\OrganizationBetRecordsController@search']);

	//總合
	Route::get('/total', ['as' => 'front.organization_bet_record.index','uses'=>'Front\Member\OrganizationBetRecordsController@index']);

	//搜尋明細結果
	Route::get('/detail/{user_id}', ['as' => 'front.organization_bet_record.detail','uses'=>'Front\Member\OrganizationBetRecordsController@detail']);
});	

/*登入紀錄*/
Route::group(['prefix' => '/login_record','middleware'=> ['auth','verify','web.status']], function() {


	//搜尋頁面
	Route::get('/', ['as' => 'front.login_record.search','uses'=>'Front\Member\LoginRecordsController@search']);

	//搜尋明細結果
	Route::post('/', ['as' => 'front.login_record.detail','uses'=>'Front\Member\LoginRecordsController@index']);


});	

/*象棋開獎紀錄*/
Route::group(['prefix' => '/cn_chess_history','middleware'=> ['auth','verify','web.status']], function() {

	Route::get('/{start?}', ['as' => 'front.cn_chess_history.index','uses'=>'Front\Member\CnChessHistoryController@index']);


});	
