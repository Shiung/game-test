<?php
use Illuminate\Support\Facades\Input;

/*
    |--------------------------------------------------------------------------
    |  象棋SSE
    |--------------------------------------------------------------------------        
*/

	//象棋ＳＳＥ
	Route::group(['prefix' => '/SSE'] , function() {

		Route::get('/header', ['uses'=>'Front\Game\CnChessSSEController@header']);
		Route::get('/last_lottery', ['uses'=>'Front\Game\CnChessSSEController@last_lottery']);
		Route::get('/last_five_lottery', ['uses'=>'Front\Game\CnChessSSEController@last_five_lottery']);
		Route::get('/balance', ['uses'=>'Front\Game\CnChessSSEController@balance']);
		Route::get('/bet', ['uses'=>'Front\Game\CnChessSSEController@bet']);
		Route::get('/chess_bet_one', ['uses'=>'Front\Game\CnChessSSEController@chess_bet_one']);
		

	});



	//view
	Route::get('/header', function(){
			return view('front.game.cn_chess.web.header');
		});
	Route::get('/last_lottery', function(){
			return view('front.game.cn_chess.web.latest_lottery');
		});




