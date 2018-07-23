<?php
use Illuminate\Support\Facades\Input;
Route::pattern('id', '[0-9]+');
Route::pattern('start','[0-9]{4}-[0-9]{2}-[0-9]{2}');
Route::pattern('end','[0-9]{4}-[0-9]{2}-[0-9]{2}');
/*
    |--------------------------------------------------------------------------
    |  遊戲大廳
    |--------------------------------------------------------------------------        
*/

Route::group(['prefix' => '/game','middleware'=> ['auth','verify','web.status']], function() {

	Route::get('/', ['as' => 'front.game.index','uses'=>'Front\Game\CategoriesController@index']);

	Route::get('/category/{type}', ['as' => 'front.game.category.index','uses'=>'Front\Game\CategoriesController@redirectSportIndex']);

	Route::get('/category/{type}/history/{start?}', ['as' => 'front.game.category.history','uses'=>'Front\Game\CategoriesController@redirectHistory']);

	//球類競賽資訊
	Route::group(['prefix' => '/sport'], function() {
		//單一球類類別賽程列表
		Route::get('/category/{type}', ['as' => 'front.game.sport.index','uses'=>'Front\Game\SportsController@index']);
		//歷史賽程列表
		Route::get('/category/{type}/history/{start?}', ['as' => 'front.game.sport.history','uses'=>'Front\Game\SportsController@history']);

		//賭盤
		Route::group(['prefix' => '/gamble'], function() {
		    //玩法資料更新
		    Route::get('/refresh/{id}', ['as' => 'front.game.sport.gamble.refresh','uses'=>'Front\Game\SportsController@gambleData']);
		    
		    //玩法列表
		    Route::get('/{id}', ['as' => 'front.game.sport.gamble.index','uses'=>'Front\Game\SportsController@gambleIndex']);
		    //下注畫面
		    Route::get('/{id}/bet/{gamble}/{line}', ['as' => 'front.game.sport.gamble.bet_index','uses'=>'Front\Game\SportsController@betIndex']);
		    //下注
		    Route::post('/bet', ['as' => 'front.game.sport.gamble.bet','uses'=>'Front\Game\SportsController@gambleBet']);

	    });
	});

	//彩球539資訊
	Route::group(['prefix' => '/lottery539'], function() {
		//歷史開獎列表
		Route::get('/category/{type}/history/{start?}', ['as' => 'front.game.lottery539.history','uses'=>'Front\Game\Lottery539sController@history']);

		//賭盤
		Route::group(['prefix' => '/gamble'], function() {

		    //玩法列表
		    Route::get('/', ['as' => 'front.game.lottery539.gamble.index','uses'=>'Front\Game\Lottery539sController@gambleIndex']);
		    //下注畫面
		    Route::get('/{id}/bet', ['as' => 'front.game.lottery539.gamble.bet_index','uses'=>'Front\Game\Lottery539sController@betIndex']);
		    
		    //下注
		    Route::post('/bet', ['as' => 'front.game.lottery539.gamble.bet','uses'=>'Front\Game\Lottery539sController@gambleBet']);

	    });
	});

	//象棋資訊
	Route::group(['prefix' => '/cn_chess'], function() {
		//入口-選籌碼
		Route::get('/entry', ['as' => 'front.game.cn_chess.entry','uses'=>'Front\Game\CnChessController@entry']);
		//下注紀錄
		Route::get('/bet_records', ['as' => 'front.game.cn_chess.bet_records','uses'=>'Front\Game\CnChessController@betRecord']);
		//開獎紀錄
		Route::get('/history_lottery', ['as' => 'front.game.cn_chess.history_lottery','uses'=>'Front\Game\CnChessController@historyLottery']);
		
		Route::get('/', ['as' => 'front.game.cn_chess.index','uses'=>'Front\Game\CnChessController@index']);
		//下注
		Route::post('/bet', ['as' => 'front.game.cn_chess.gamble.bet','uses'=>'Front\Game\CnChessBetController@gambleBet']);

	    
	});




});



