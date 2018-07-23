<?php

namespace App\Http\Controllers\Front\Game;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Services\Game\Sport\SportGameService;
use App\Services\Game\Sport\Lottery539Service;
use App\Services\Game\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;
use Auth;

class Lottery539sController extends Controller
{
    /**
     * 參數設定
     *
     * @var string
     */
    protected $sportService;
    protected $sportGameService;
    protected $categoryService;
    protected $page_title = '彩球539';
    protected $route_code = 'lottery539';
    protected $number_to_code = [];
    protected $user;
    protected $accounts;


    /**
     * 開頭宣告
     *
     * @return void
     */
    public function __construct(
        Lottery539Service $sportService,
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
     * 歷史開獎資料頁面（已結束）
     * @param string $type 遊戲類別代碼 （參考config/game.php）
     * @param date $date 日期
     * @return view  front/game/lottery539/history.blade.php
     */
    public function history($type,$date = null)
    {
        if(!$date){
            $date = date('Y-m-d');
        } 
        $datas = $this->sportService->allByStatus(3,1,$date,$date); 
        $category = $this->categoryService->find(3);
        $data =[
            'datas' => $datas,
            'date' => $date,
            'type' => $type,
            'route_code' => $this->route_code,
            'page_title' => $category->name
        ];
        return view('front.game.'.$this->route_code.'.history',$data);
    }


    /**
     * 玩法列表
     * 
     * @return view  front/game/lottery539/gamble/index.blade.php
     */
    public function gambleIndex()
    {
        $date_info = getDefaultDateRange(1);
        $start = $date_info['start'];
        $end = $date_info['end'];
        $games = $this->sportGameService->all(3,1,$start,$end );
        $category = $this->categoryService->find(3);

        $game_type = config('game.category.'.$category->type.'.type');

        $data =[
            'account_amount' => $this->accounts,
            'games' => $games,
            'category' => $category,
            'route_code' => $this->route_code,
            'page_title' => $category->name
        ];
        return view('front.game.'.$this->route_code.'.gamble.index',$data);

    }

    /**
     * 下注畫面
     * @param int $sport_game_id 賭盤id,
     * 
     * @return view  front/game/lottery539/gamble.遊戲類型.blade.php
     */
    public function betIndex($sport_game_id)
    {
        $game = $this->sportGameService->find($sport_game_id);
        if(!$game){
            abort(404);
        }
        if($game->bet_status != '1'){
            return '已關閉下注';
        }

        $sport = $game->sport;

        $parameters = $this->sportGameService->getGameParameter($game->type,$game,$sport);

        $category = $sport->category;
        $game_type = config('game.category.'.$category->type.'.type');

        $data =[
            'account_amount' => $this->accounts,
            'data' => $game,
            'route_code' => $this->route_code,
            'parameters' => $parameters,
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
            return json_encode(array('result' => 0, 'text' => '已關閉，無法下注'));
        }
        if($game->bet_status != '1'){
            return json_encode(array('result' => 0, 'text' => '已關閉，無法下注'));
        }
        //下注額檢查，不能全為0
        if($request->virtual_cash_amount == 0 && $request->manage_amount == 0 && $request->share_amount == 0 && $request->interest_amount == 0){
            return json_encode(array('result' => 0, 'text' => '請輸入下注額'));
        }
        $numbers = json_decode($request->numbers, true);
        if(count($numbers) != 3){
            return json_encode(array('result' => 0, 'text' => '請選擇3個號碼'));
        }
        //檢查數字格式
        if(!$this->sportService->checkIfNumbersValid($numbers)){
            return json_encode(array('result' => 0, 'text' => '號碼有誤，請重新確認'));
        }
        $data = $request->all();
        $data['numbers'] = $numbers;
        $result = $this->sportGameService->bet($game->type,$game,$data);
        if ($result['status']) {
            return json_encode(array('result' => 1, 'text' => 'Success','detail' => $result['content']));
        } else {
            if($result['error_code'] == 'LINE_CHANGED'){
                return json_encode(array('result' => 2, 'text' => '賠率已改變，請重新下注'));
            } else {
                return json_encode(array('result' => 0, 'text' => $result['error_msg']));
            }
            
        }  

    }


}
