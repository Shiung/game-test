<?php

namespace App\Http\Controllers\Front\Game;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Services\Game\Sport\SportService;
use App\Services\Game\Sport\SportGameService;
use App\Services\Game\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;
use Auth;

class SportsController extends Controller
{
    /**
     * 參數設定
     *
     * @var string
     */
    protected $sportService;
    protected $sportGameService;
    protected $categoryService;
    protected $page_title = '球類競賽';
    protected $route_code = 'sport';
    protected $number_to_code = [];
    protected $user;
    protected $accounts;


    /**
     * 開頭宣告
     *
     * @return void
     */
    public function __construct(
        SportService $sportService,
        SportGameService $sportGameService,
        CategoryService $categoryService
    ) {
        $this->sportService = $sportService;
        $this->sportGameService = $sportGameService;
        $this->categoryService = $categoryService;
        $this->number_to_code = config('game.sport.game.number_to_code');
        
        //可用餘額
        $this->user = Auth::guard('web')->user();
        $accounts = $this->user->member->accounts;
        $this->accounts = [
            'cash' => $accounts->where('type','1')->first()->amount,
            'run' => $accounts->where('type','2')->first()->amount,
            'interest' => $accounts->where('type','4')->first()->amount,
            'right' => $accounts->where('type','3')->first()->amount
        ];
    }
    
    /**
     * 最新賽程資料頁面（未打完）
     * @param string $type 遊戲類別代碼 （參考config/game.php）
     * @return view  front/game/sport/index.blade.php
     */
    public function index($type)
    {
        $datas = $this->sportService->getCompleteGames($type);

        $data =[
            'datas' => $datas,
            'type' => $type,
            'route_code' => $this->route_code,
            'account_amount' => $this->accounts,
            'page_title' =>  config('game.category.'.$type.'.name') 
        ];
        return view('front.game.'.$this->route_code.'.index',$data);

    }

    /**
     * 歷史賽程資料頁面（已結束）
     * @param string $type 遊戲類別代碼 （參考config/game.php）
     * @param date $date 
     * @return view  front/game/sport/history.blade.php
     */
    public function history($type,$date = null)
    {
        if(!$date){
            $date = date('Y-m-d');
        } 
        $datas = $this->sportService->getHistoryGames($type,$date,$date);
        
        $data =[
            'datas' => $datas,
            'date' => $date,
            'type' => $type,
            'route_code' => $this->route_code,
            'page_title' => config('game.category.'.$type.'.name') 
        ];
        return view('front.game.'.$this->route_code.'.history',$data);
    }


    /**
     * 單一賽程玩法列表
     * $sport_id
     * @return view  front/game/sport/gamble/list.blade.php
     */
    public function gambleIndex($sport_id)
    {
        $sport = $this->sportService->find($sport_id);
        if(!$sport ){
            abort(404);
        }
        $teams = $sport->teams;

        $datas = $sport->games;

        $category = $sport->category;

        $game_type = config('game.category.'.$category->type.'.type');

        $data =[
            'cash_account' => 500,
            'account_amount' => $this->accounts,
            'datas' => $datas,
            'sport' => $sport,
            'games' => $this->sportGameService->showGamesBySport($sport),
            'category' => $category,
            'home_team' => $teams->where('home','1')->first(),
            'away_team' => $teams->where('home','0')->first(),
            'route_code' => $this->route_code,
            'page_title' => $category->name
        ];
        return view('front.game.'.$this->route_code.'.gamble.list.'.$game_type,$data);

    }

    /**
     * 單一賽程玩法資料
     * @param int $sport_id 賽程id
     * @return string
     */
    public function gambleData($sport_id)
    {
        $sport = $this->sportService->find($sport_id);
        if(!$sport){
            abort(404);
        }
        return json_encode($this->sportGameService->showGamesBySport($sport));


    }

    /**
     * 下注畫面
     * @param int $sport_game_id 賭盤id
     * @param int $gamble 下注選項
     * @param float $line 選項賠率
     * @return view  front/game/sport/gamble/bet/遊戲類型.blade.php
     */
    public function betIndex($sport_game_id,$gamble,$line)
    {
        $game = $this->sportGameService->find($sport_game_id);
        if(!$game){
            abort(404);
        }
        if($game->bet_status != '1'){
            return '已關閉下注';
        }

        //檢查選項
        if(!$this->sportGameService->checkGambleExist($game->type,$game,['gamble'=>$gamble])){
            return '下注選項不存在';
        }
        $sport = $game->sport;
        $teams = $sport->teams;
        //設定賠率
        $parameters = $this->sportGameService->getGameParameter($game->type,$game,$sport,$teams);
        if($parameters['home_data']['gamble'] == $gamble){
            $line = $parameters['home_data']['line'];
            $gamblename = $parameters['home_data']['gamblename'];
        }
        if($parameters['away_data']['gamble'] == $gamble){
            $line = $parameters['away_data']['line'];
            $gamblename = $parameters['away_data']['gamblename'];
        }

        $category = $sport->category;
        $game_type = config('game.category.'.$category->type.'.type');

        $data =[
            'account_amount' => $this->accounts,
            'sport' => $sport,
            'data' => $game,
            'category' => $category,
            'home_team' => $teams->where('home','1')->first(),
            'away_team' => $teams->where('home','0')->first(),
            'route_code' => $this->route_code,
            'gamble' => $gamble,
            'gamblename' => $gamblename,
            'parameters' => $parameters,
            'line' => $line,
            'page_title' => $category->name
        ];

        $game_type = config('game.sport.game.number_to_code.'.$game->type);
        return view('front.game.'.$this->route_code.'.gamble.bet.'.$game_type,$data);
    }

    /**
     * 下注
     * @param Request $request
     * @return json
     */
    public function gambleBet(Request $request)
    {
        $game = $this->sportGameService->find($request->game_id);
        if(!$game){
            return json_encode(array('result' => 0, 'error_code' => 'BET_CLOSE', 'text' => '已關閉，無法下注'));
        }
        if($game->bet_status != '1'){
            return json_encode(array('result' => 0, 'error_code' => 'BET_CLOSE', 'text' => '已關閉，無法下注'));
        }
        //下注額檢查，不能全為0
        if($request->virtual_cash_amount == 0 && $request->share_amount == 0 && $request->manage_amount == 0 && $request->interest_amount == 0){
            return json_encode(array('result' => 0, 'error_code' => 'AMOUNT_REQUEST', 'text' => '請輸入下注額'));
        }
        $result = $this->sportGameService->bet($game->type,$game,$request->all());
        if ($result['status']) {
            return json_encode(array('result' => 1, 'text' => 'Success','detail' => $result['content']));
        } else {
            return json_encode(array('result' => 0, 'error_code' => $result['error_code'], 'text' => $result['error_msg']));
        }  

    }


}
