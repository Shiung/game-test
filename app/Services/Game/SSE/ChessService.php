<?php
namespace App\Services\Game\SSE;

use App;
use App\Models\Sport\Sport;
use App\Models\Sport\SportTeam;
use App\Models\Sport\SportGame;
use App\Models\Sport\SportGameOverUnder;
use App\Models\Sport\SportGameSpread;
use App\Models\Sport\SportGame539;
use App\Models\Sport\SportBetRecord;
use App\Models\Sport\SportBetOverunder;
use App\Models\Sport\SportBetSpread;
use App\Models\Sport\SportBet539;
use App\Models\Sport\SportBetCnChessNum;
use App\Models\Sport\SportBetCnChessColor;
use App\Models\Sport\Sport539Number;
use App\Models\Sport\SportCnChessNumber;
use App\Models\Sport\SportGameCnChessNum;
use App\Models\Sport\SportGameCnChessColor;
use App\Models\Sport\CnChess;
use App\Models\Account\Account;
use App\Models\System\Parameter;
use Illuminate\Support\Facades\DB;
use Exception;
use Session;
use Auth;

class ChessService {
    
    //header 計時info
    public function sport_chess()
    {
        $sport = sport::where('sport_category_id',4)->orderBy('start_datetime','desc')->first();
        $sec = strtotime($sport->start_datetime) - strtotime('now');
        $number = $sport->sport_number;
        $today_num = explode("-", $number);
        $r = json_encode(['sec'=>$sec, 'number'=>$number, 'datetime'=>date("Y-m-d H:i:s"), 'sport_id'=>$sport->id]);
        return $r;
    }


    //最新開獎
    public function open_number()
    {
        $open_numbers = SportCnChessNumber::orderBy('created_at','desc')->limit(5)->get();
        $open = [];
        $i=1;
        $ex_sport_id = 0;
        $check = 0;

        foreach ($open_numbers as $open_number) {
            if($i>1){
                if($ex_sport_id != $open_number->sport_id){
                    $check = 1;
                }
            }
            $ex_sport_id = $open_number->sport_id;
            $sport_number = $open_number->sport->sport_number;
            $today_num = explode("-",$sport_number);
            $open['sport_number'] = $today_num[1];
            $open[$i] = $open_number->number;
            $i++;
        }

        if($check==1){
            $this->open_number();
        }else{
            $r = json_encode($open);
            return $r;
        }
        
    }


    //進五期開獎
    public function last_five_lottery()
    {
        $open_arr = [];
        $last_five_sport_ids = DB::select("SELECT * 
                                        FROM sport_cn_chess_numbers
                                        GROUP BY sport_id
                                        ORDER BY sport_id DESC 
                                        LIMIT 0 , 5");
        foreach ($last_five_sport_ids as $sport) {
            $number = Sport::find($sport->sport_id)->sport_number;
            $today_num = explode("-",$number);
            $sport_number = $today_num[1];
            $lottery_numbers = SportCnChessNumber::where('sport_id',$sport->sport_id)->get();
            $num_arr = ['sport_number'=>$sport_number];
            foreach ($lottery_numbers as $lottery_number) {
                $chess_name = $lottery_number->chess->name;
                $chess_color = $lottery_number->chess->color;
                if($chess_color==0){
                    $chess_html = "<div class=\"history_chess_red\">".$chess_name."</div>";
                }else{
                    $chess_html = "<div class=\"history_chess_black\">".$chess_name."</div>";
                }
                
                array_push($num_arr, $chess_html);
            }
            array_push($open_arr,$num_arr);
        }
        $r = json_encode($open_arr);
        return $r;
    }


    //balance of user
    public function balance($user_id)
    {
        $accounts = Account::where('member_id',$user_id)->get();

        foreach ($accounts as $account) {
            switch ($account->type) {
                case 1:
                    $balance['virtual_cash'] = number_format($account->amount);
                    break;
                
                case 2:
                    $balance['manage'] = number_format($account->amount);
                    break;

                case 3:
                    $balance['share'] = number_format($account->amount);
                    break;

                case 4:
                    $balance['interest'] = number_format($account->amount);
                    break;

                default:
                    # code...
                    break;
            }
        }
        
        $r = json_encode($balance);
        //echo $r;
        return $r;
        
    }


    //近10筆下注紀錄
    public function user_bets($user_id)
    {
        $bets = SportBetRecord::whereIn('type',[4,5])
                                ->where('member_id',$user_id)
                                ->orderBy('created_at','desc')
                                ->limit(10)
                                ->get();
        $bet_records = [];

        foreach ($bets as $bet) {
            $number = $bet->game->sport->sport_number;
            $today_num = explode("-",$number);
            $sport_number = $today_num[1];

            $bet_record = [
                        'sport_number' => $sport_number,
                        'account_type' => $bet->account->type,
                        'amount' => number_format($bet->amount),
                        'gamble' => '',
                    ];

            $details = $bet->detail;
            foreach ($details as $detail) {
                //選兩個
                if($bet->type=='4'){
                   
                    $bet_record['gamble'] .= $detail->gamble;
                    
                //紅黑
                }elseif($bet->type=='5'){
                    if($detail->gamble==0)
                        $bet_record['gamble'] .= "R";
                    else
                        $bet_record['gamble'] .= "B";
                }
                
            }

            array_push($bet_records,$bet_record);
        }

        $r = json_encode($bet_records);
        return $r;
    }


    //inject for all information in chess view
    public function info($key)
    {
        $cn_chess_interval = Parameter::where('name','cn_chess_interval')->firstOrFail()->value;
        $cn_chess_resttime = Parameter::where('name','cn_chess_resttime')->firstOrFail()->value;
        $start_count = $cn_chess_interval*60 - $cn_chess_resttime;


        $sport = sport::where('sport_category_id',4)->orderBy('start_datetime','desc')->first();
        $sec = strtotime($sport->start_datetime) - strtotime('now');
        if($sec<0)
            $sec=0;
        $sport_number = $sport->sport_number;
        $today_num = explode("-",$sport_number);
        $number = $today_num[1];

        //$open_numbers = SportCnChessNumber::orderBy('created_at','desc')->limit(5)->get();


        $info = [
            'sec' => $sec,
            'sport_number' => $sport_number,
            'start_count' => $start_count,
            'start_datetime' => strtotime($sport->start_datetime),
            'sport_id' => $sport->id,
            'interval_sec' => $cn_chess_interval*60,
            //'open_numbers' => $open_numbers,
        ];

        return $info[$key];
    }


    //象棋單一局統計
    public function chess_bet_one()
    {
        try{

            $user = Auth::guard('web')->user();
            $user_id = $user->id;

            $sport = Sport::where('sport_category_id',4)->orderBy('start_datetime', 'desc')->skip(1)->take(1)->first();


            //find game id
            $games = SportGame::where('sport_id',$sport->id)->get();
            $game_ids = [];
            foreach ($games as $game) {
                array_push($game_ids, $game->id);
            }

            $sum = [];

            //計算金幣小計 直接加總並顯示於金幣
            $cash_sum = SportBetRecord::whereIn('sport_game_id',$game_ids)->where('sport_bet_records.member_id',$user_id)
                                ->join('accounts','accounts.id','=','sport_bet_records.account_id')
                                ->where('accounts.type',1)
                                ->sum('result_amount');

            //計算禮券 紅利小計 結果正轉為金幣 下注金額為原本幣值的負數
            $account_sum_cash = SportBetRecord::whereIn('sport_game_id',$game_ids)->where('sport_bet_records.member_id',$user_id)
                                ->join('accounts','accounts.id','=','sport_bet_records.account_id')
                                ->whereIn('accounts.type',[2,3,4])->where('result_amount','>',0)
                                ->sum('result_amount');

            $manage_sum = SportBetRecord::whereIn('sport_game_id',$game_ids)->where('sport_bet_records.member_id',$user_id)
                                ->join('accounts','accounts.id','=','sport_bet_records.account_id')
                                ->where('accounts.type',2)
                                ->sum('sport_bet_records.amount');

            $interest_sum = SportBetRecord::whereIn('sport_game_id',$game_ids)->where('sport_bet_records.member_id',$user_id)
                                ->join('accounts','accounts.id','=','sport_bet_records.account_id')
                                ->where('accounts.type',4)
                                ->sum('sport_bet_records.amount');

            //計算娛樂幣小計 結果正為金幣 結果負為娛樂避
            $share_sum = SportBetRecord::whereIn('sport_game_id',$game_ids)->where('sport_bet_records.member_id',$user_id)
                                ->join('accounts','accounts.id','=','sport_bet_records.account_id')
                                ->where('accounts.type',3)->where('result_amount','<',0)
                                ->sum('result_amount');

            $cash_sum_result = $cash_sum + $account_sum_cash;
            array_push($sum, ['account_type'=>1, 'sum_result'=> $cash_sum_result]);
            array_push($sum, ['account_type'=>2, 'sum_result'=> -$manage_sum]);
            array_push($sum, ['account_type'=>3, 'sum_result'=> $share_sum]);
            array_push($sum, ['account_type'=>4, 'sum_result'=> -$interest_sum]);

        }catch(Exception $e){
            return json_encode(["result"=>0, "error_code"=>'ERROR', "error_msg"=>'查詢失敗', "detail"=>$e->getMessage()]);
        }

        return json_encode(["result"=>1, "detail"=>$sum]);

    }
}
