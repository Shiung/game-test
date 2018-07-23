<?php

namespace App\Http\Controllers\Front\Game;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Services\Game\Sport\SportGameService;
use App\Services\Game\Sport\CnChessService;
use App\Services\System\CnChessChipService;
use App\Services\Game\SSE\ChessService;
use App\Services\Game\CategoryService;
use App\Services\Member\MemberService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;
use Auth;

class CnChessController extends Controller
{
    /**
     * 參數設定
     *
     * @var string
     */
    protected $sportService;
    protected $sportGameService;
    protected $categoryService;
    protected $chessService;
    protected $sseChessService;
    protected $chessChipService;
    protected $memberService;
    protected $page_title = '象棋';
    protected $route_code = 'cn_chess';
    protected $number_to_code = [];
    protected $user;
    protected $accounts;


    /**
     * 開頭宣告
     *
     * @return void
     */
    public function __construct(
        SportGameService $sportGameService,
        CnChessService $chessService,
        CnChessChipService $chessChipService,
        ChessService $sseChessService,
        MemberService $memberService,
        CategoryService $categoryService
    ) {
        $this->sportGameService = $sportGameService;
        $this->categoryService = $categoryService;
        $this->chessService = $chessService;
        $this->chessChipService = $chessChipService;
        $this->sseChessService = $sseChessService;
        $this->memberService = $memberService;
        $this->number_to_code = config('game.sport.game.number_to_code');
        
        $this->user = Auth::guard('web')->user();
    }

    /**
     * 象棋入口-選籌碼
     * 
     * @return view  front/game/cn_chess/chip_select.blade.php
     */
    public function entry()
    {
        $chips= $this->chessChipService->all();
        $chip_settings = [];
        foreach ($chips as $chip) {
            $chip_data = json_decode($chip->content, true);
            $chip_settings[$chip->id] = $chip_data[1]['name'];
        }

        $data =[
            'page_title' => '象棋',
            'chip_settings' => $chip_settings,
        ];
        return view('front.game.'.$this->route_code.'.chip_select',$data);
    }

    /**
     * 象棋頁面重新導向，判斷導向哪一種裝置頁面&籌碼組合
     * @param Request $request
     * @return function
     */
    public function index(Request $request)
    {
        if($request->has('chip')){
            if($request->chip <1 || $request->chip > 4){
                $chip = 1;
            } else {
                $chip = $request->chip;
            }
            
        } else {
            $chip = 1;
        }

        if($request->has('type')){
            $type = $request->type;
        } else {
            $type = 'w';
        }

        if($type == 'w'){
            return $this->webIndex($chip);
        }

        if($type == 'm'){
            return $this->mobileIndex($chip);
        }
    }
    

    /**
     * 象棋頁面(web)
     * @param int $chip 籌碼id
     * @return view  front/game/cn_chess/web.main.blade.php
     */
    public function webIndex($chip =1)
    {
        $chip_data= $this->chessChipService->find($chip);
        $investment_name = [];
        $investment_to_id = [];
        $investment_bet_data = [];
        $first_investment = 0;
        $chip_data = json_decode($chip_data->content, true);
        foreach ($chip_data as $key => $value) {
            $investment_name[$value['amount']] = $value['name'];
            $investment_to_id[$value['amount']] = $key;
            $investment_bet_data[$key] = ['amount' => $value['amount'], 'name'=> $value['name']];
            if($key == '1'){
                $first_investment = $value['amount'];
            }
        }

        //會員等級資訊
        $member_level_info = $this->memberService->searchMemberLevel($this->user->id,$this->user->type);


        //設置籌碼參數
        $config_data = [
            'investment_name' => $investment_name,
            'investment_to_id' => $investment_to_id,
            'first_investment' => $first_investment
        ];

        $data =[
            'route_code' => $this->route_code,
            'page_title' => $this->page_title,
            'config_data' => json_encode($config_data),
            'investment_bet_data' => $investment_bet_data,
            'level_expire' => $member_level_info['level_expire'],
            'level' => $member_level_info['level_name'],
            'member' => $this->user->member,
            'user' => $this->user
        ];
        return view('front.game.'.$this->route_code.'.web.main',$data);
    }

    /**
     * 象棋頁面(手機)
     * @param int $chip 籌碼id
     * @return view  front/game/cn_chess/mobile.main.blade.php
     */
    public function mobileIndex($chip)
    {
        $chip_data= $this->chessChipService->find($chip);
        $investment_name = [];
        $investment_to_id = [];
        $investment_bet_data = [];
        $first_investment = 0;
        $chip_data = json_decode($chip_data->content, true);
        foreach ($chip_data as $key => $value) {
            $investment_name[$value['amount']] = $value['name'];
            $investment_to_id[$value['amount']] = $key;
            $investment_bet_data[$key] = ['amount' => $value['amount'], 'name'=> $value['name']];
            if($key == '1'){
                $first_investment = $value['amount'];
            }
        }


        //設置籌碼參數
        $config_data = [
            'investment_name' => $investment_name,
            'investment_to_id' => $investment_to_id,
            'first_investment' => $first_investment
        ];

        $data =[
            'route_code' => $this->route_code,
            'page_title' => $this->page_title,
            'config_data' => json_encode($config_data),
            'investment_bet_data' => $investment_bet_data,
        ];
        return view('front.game.'.$this->route_code.'.mobile.main',$data);
    }

    /**
     * 近十筆下注紀錄
     * 
     * @return view  front/game/cn_chess/mobile.bet_record.blade.php
     */
    public function betRecord()
    {
        $datas = $this->sseChessService->user_bets($this->user->id);

        $data =[
            'datas' => $datas,
            'route_code' => $this->route_code,
            'page_title' => $this->page_title
        ];
        return view('front.game.'.$this->route_code.'.mobile.bet_record',$data);
    }

    /**
     * 近五筆開獎紀錄
     * 
     * @return view  front/game/cn_chess/mobile.history_lottery.blade.php
     */
    public function historyLottery()
    {
        $datas = $this->sseChessService->last_five_lottery();

        $data =[
            'datas' => $datas,
            'route_code' => $this->route_code,
            'page_title' => $this->page_title
        ];
        return view('front.game.'.$this->route_code.'.mobile.history_lottery',$data);
    }

    /**
     * 下注
     * @param Request $request
     * @return json
     */
    /*public function gambleBet(Request $request)
    {
        $result = $this->chessService->bet($request->all());
        if ($result['status']) {
            return json_encode(array('result' => 1, 'text' => 'Success','detail' => $result['content']));
        } else {
            if($result['error_code']== 'INSUFFICIENT_BALANCE'){
                $data = [];

                //會員等級資訊
                $member_level_info = $this->memberService->searchMemberLevel($this->user->id,$this->user->type);

                $member = $this->user->member;

                $member_info = [
                    'level' => $member_level_info['level_name'],
                    'member_number' => $member->member_number,
                    'username' => $this->user->username,
                    'member_name' => $member->name,
                ];

                //可用餘額
                $accounts = $member->accounts;
                $account_info =  [
                    'cash' => $accounts->where('type','1')->first()->amount,
                    'run' => $accounts->where('type','2')->first()->amount,
                    'interest' => $accounts->where('type','4')->first()->amount,
                    'right' => $accounts->where('type','3')->first()->amount
                ];


                return json_encode(array('result' => 0, 'error_code' => $result['error_code'], 'text' => $result['error_msg'],'account_info' => $account_info,'member_info' => $member_info));
            } else {
                return json_encode(array('result' => 0, 'error_code' => $result['error_code'], 'text' => $result['error_msg']));
            }
            
            
        }  

    }*/


    


   


}
