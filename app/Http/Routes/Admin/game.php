<?php
use Illuminate\Support\Facades\Input;

Route::pattern('id', '[0-9]+');
Route::pattern('start','[0-9]{4}-[0-9]{2}-[0-9]{2}');
Route::pattern('end','[0-9]{4}-[0-9]{2}-[0-9]{2}');
/*
    |--------------------------------------------------------------------------
    | 後台-遊戲相關功能
    |--------------------------------------------------------------------------        
*/

Route::group(['prefix' => '/game-admin/dashboard/game', 'middleware' => ['auth.admin']], function() {
       
    /*賽程-球類*/
    Route::group(['prefix' => '/sport', 'middleware' => ['role:super-admin|master-admin|sport-preview']], function() {
        
        //所有賭盤
        Route::get('/gambles/{category_id}/{start?}/{end?}', ['as' => 'admin.game.sport.gambles','uses'=>'Admin\Game\SportGamesController@index']);
            
        /*賭盤*/
        Route::group(['prefix' => '/gamble', 'middleware' => ['role:super-admin|master-admin|sport-preview']], function() {
            //編輯
            Route::get('/edit/{id}', ['as' => 'admin.game.sport.gamble.edit','uses'=>'Admin\Game\SportGamesController@edit']);
            //顯示
            Route::get('/show/{id}', ['as' => 'admin.game.sport.gamble.show','uses'=>'Admin\Game\SportGamesController@show']);
            //下注明細
            Route::get('/bet_records/{id}', ['as' => 'admin.game.sport.gamble.bet_record','uses'=>'Admin\Game\SportGamesController@betRecord']);
            
            //列表
            Route::get('/{sport_id}', ['as' => 'admin.game.sport.gamble.index','uses'=>'Admin\Game\SportsController@gamebleIndex']);
            //新增
            Route::get('/create/{sport_id}/{type}', ['as' => 'admin.game.sport.gamble.create','uses'=>'Admin\Game\SportGamesController@create']);
            //新增處理
            Route::post('/', ['as' => 'admin.game.sport.gamble.store','uses'=>'Admin\Game\SportGamesController@store']);
            
            //編輯處理
            Route::put('/{id}', ['as' => 'admin.game.sport.gamble.update','uses'=>'Admin\Game\SportGamesController@update']);
            //更新下注狀態
            Route::put('/change-status/{id}', ['as' => 'admin.game.sport.gamble.change_status','uses'=>'Admin\Game\SportGamesController@changeStatus']);
 
            //刪除處理
            Route::delete('/{id}', ['as' => 'admin.game.sport.gamble.destroy','uses'=>'Admin\Game\SportGamesController@destroy']);
            
        });

        //歷史賽程列表
        Route::get('/history/{category_id}/{start?}/{end?}', ['as' => 'admin.game.sport.history','uses'=>'Admin\Game\SportsController@history']);
        //賽程詳細資訊
        Route::get('/show/{id}', ['as' => 'admin.game.sport.show','uses'=>'Admin\Game\SportsController@show']);
        
        //最新賽程列表
        Route::get('/latest/{category_id}', ['as' => 'admin.game.sport.index','uses'=>'Admin\Game\SportsController@index']);
        
        //新增賽程
        Route::get('/create/{category_id}', ['as' => 'admin.game.sport.create','uses'=>'Admin\Game\SportsController@create']);
        //新增處理
        Route::post('/', ['as' => 'admin.game.sport.store','uses'=>'Admin\Game\SportsController@store']);
        
        
        //編輯
        Route::get('/edit/{id}', ['as' => 'admin.game.sport.edit','uses'=>'Admin\Game\SportsController@edit']);
        //編輯處理
        Route::put('/{id}', ['as' => 'admin.game.sport.update','uses'=>'Admin\Game\SportsController@update']);
        //更新分數處理
        Route::put('/score/{id}', ['as' => 'admin.game.sport.update_score','uses'=>'Admin\Game\SportsController@updateScore']);
        //編輯賽程狀態
        Route::get('/edit_status/{id}', ['as' => 'admin.game.sport.edit_status','uses'=>'Admin\Game\SportsController@editStatus']);
        //更新賽程狀態處理
        Route::put('/status/{id}', ['as' => 'admin.game.sport.update_status','uses'=>'Admin\Game\SportsController@updateStatus']);
        
        
        //刪除處理
        Route::delete('/{id}', ['as' => 'admin.game.sport.delete','uses'=>'Admin\Game\SportsController@destroy']);
        
    });

    /*賽程-539*/
    Route::group(['prefix' => '/lottery539', 'middleware' => ['role:super-admin|master-admin|sport-preview']], function() {
        
        //列表
        Route::get('/', ['as' => 'admin.game.lottery539.index','uses'=>'Admin\Game\Lottery539sController@index']);
        
        //編輯
        Route::get('/edit/{id}', ['as' => 'admin.game.lottery539.edit','uses'=>'Admin\Game\Lottery539sController@edit']);
        //編輯處理
        Route::put('/{id}', ['as' => 'admin.game.lottery539.update','uses'=>'Admin\Game\Lottery539sController@update']);
        
        /*賭盤*/
        Route::group(['prefix' => '/gamble', 'middleware' => ['role:super-admin|master-admin|sport-preview']], function() {
            //編輯
            Route::get('/edit/{id}', ['as' => 'admin.game.lottery539.gamble.edit','uses'=>'Admin\Game\Lottery539GamesController@edit']);
            //顯示
            Route::get('/show/{id}', ['as' => 'admin.game.lottery539.gamble.show','uses'=>'Admin\Game\Lottery539GamesController@show']);
            //下注明細
            Route::get('/bet_records/{id}', ['as' => 'admin.game.lottery539.gamble.bet_record','uses'=>'Admin\Game\Lottery539GamesController@betRecord']);
            
            //列表
            Route::get('/{sport_id}', ['as' => 'admin.game.lottery539.gamble.index','uses'=>'Admin\Game\Lottery539sController@gamebleIndex']);

            //編輯處理
            Route::put('/{id}', ['as' => 'admin.game.lottery539.gamble.update','uses'=>'Admin\Game\Lottery539GamesController@update']);
            //更新下注狀態
            Route::put('/change-status/{id}', ['as' => 'admin.game.lottery539.gamble.change_status','uses'=>'Admin\Game\Lottery539GamesController@changeStatus']);
 
            //刪除處理
            Route::delete('/{id}', ['as' => 'admin.game.lottery539.gamble.destroy','uses'=>'Admin\Game\Lottery539GamesController@destroy']);
            
        });

        //歷史賽程列表
        Route::get('/history/{start?}/{end?}', ['as' => 'admin.game.lottery539.history','uses'=>'Admin\Game\Lottery539sController@history']);
        //賽程詳細資訊
        Route::get('/show/{id}', ['as' => 'admin.game.lottery539.show','uses'=>'Admin\Game\Lottery539sController@show']);
        
    });

    /*賽程-象棋*/
    Route::group(['prefix' => '/cn_chess', 'middleware' => ['role:super-admin|master-admin|sport-preview']], function() {

        //歷史賽程列表
        Route::get('/history/{start?}/{end?}', ['as' => 'admin.game.cn_chess.history','uses'=>'Admin\Game\CnChessesController@history']);
        //賽程詳細資訊
        Route::get('/show/{id}', ['as' => 'admin.game.cn_chess.show','uses'=>'Admin\Game\CnChessesController@show']);
        
    });

    
    
});



