<?php

namespace App\Http\Controllers\Front\Game;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use Exception;
use DB;
use Auth;
use App\Models\Sport\Sport;
use App\Models\Sport\SportTeam;
use App\Models\Sport\SportGame;
use App\Services\API\LogService;
use App\Services\API\RoleService;
use App\Services\API\SportService;
use App\Services\Game\Sport\CnChessService;
use App\Services\Member\MemberService;

class CnChessBetController extends Controller
{

	protected $sportService;
	protected $logService;
	protected $roleService;
    protected $chessService;
    protected $memberService;
    protected $user;
    
    public function __construct(
        SportService $sportService, 
        LogService $logService, 
        RoleService $roleService, 
        CnChessService $chessService, 
        MemberService $memberService
    ) {
        
        $this->sportService =  $sportService;
        $this->logService = $logService;
        $this->roleService = $roleService;
        $this->chessService = $chessService;
        $this->memberService = $memberService;
        $this->user = Auth::guard('web')->user();

    }

    /**
     * 下注
     * @param Request $request
     * @return json
     */
    public function gambleBet(Request $request)
    {
        $bet_data = $this->chessService->bet($request->all());

        //多筆下注
        $result = $this->bet_multi($bet_data);

        if($result['result'] == 1){
            //取得成功資訊
            $content = $this->chessService->getBetSuccessInfo($result['bet_record_ids']);
            return json_encode(array('result' => 1, 'text' => 'Success','detail' => $content));
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

    }



    //多筆下注API
    public function bet_multi($bet_data)
    {
        $input = $bet_data;
        $this->roleService->column_validate($input, [
            'bets' => 'required',
        ]);

        //JSON格式判斷
        $bets = json_decode($input['bets'],1);
        if(!is_array($bets))
            return ['result'=>0, 'error_code'=>'COLUMN_ERROR',  'error_msg'=>'bets錯誤', 'detail'=>'非JSON格式'];

        //開始下注
        $bet_record_ids = [];
        DB::beginTransaction();
        foreach ($bets as $bet) {
            $r = $this->bet_one($bet);
            $result = json_decode($r,1); 
            if($result['result']==0){
                DB::rollBack();
                return $result;
            } 
            $bet_record_ids = array_merge($bet_record_ids, $result['bet_record_ids']);
        }  
        DB::commit();
        return ['result'=>1, 'success_msg'=>'下注成功', 'bet_record_ids'=>$bet_record_ids];
    } 


    //單一下注
    public function bet_one($input)
    {
        //欄位檢查
        $this->roleService->column_validate($input, [
            'sport_game_id' => 'required|min:0|integer',
            'amounts' => 'required',
            'bet_type' => 'required|in:1,2,3,4,5',
            'gamble' => 'required',
            'line' => 'required',
        ]);
        
        try{
            //sport_game_id check
            $sport_game = SportGame::where('id',$input['sport_game_id'])->where('type',$input['bet_type'])->firstOrFail();
            if($sport_game->bet_status !=1)
                return json_encode(['result'=>0, 'error_code'=>'STATUS_ERROR',  'error_msg'=>'非開放下注中', 'detail'=>$sport_game->bet_status]);

            //大小盤gamble檢查
            if($input['bet_type']==1){
                $this->roleService->column_validate($input, ['gamble' => 'required|in:0,1']);
                $gamble = $input['gamble'];

            //讓分gamble檢查
            }else if($input['bet_type']==2){
                SportTeam::where('sport_id',$sport_game->sport_id)->where('id',$input['gamble'])->firstOrFail();
                $gamble = $input['gamble'];
                
            //彩球gamble檢查
            }else if($input['bet_type']==3){
                $gamble_539 = json_decode($input['gamble'],1);
                if(!is_array($gamble_539['numbers']) || count($gamble_539['numbers'])!=3)
                    throw new Exception("彩球下注格式不正確");
                if(count(array_unique($gamble_539['numbers']))!=3)
                    throw new Exception("彩球下注號碼不可重複");
                $gamble = $gamble_539['numbers'];

            //象棋數字gamble檢查    
            }else if($input['bet_type']==4){
                $gamble_chess_num = json_decode($input['gamble'],1);
                if(!is_array($gamble_chess_num['numbers']) || count($gamble_chess_num['numbers'])!=2)
                    throw new Exception("象棋數字下注格式不正確");
                if(count(array_unique($gamble_chess_num['numbers']))!=2)
                    throw new Exception("象棋數字下注號碼不可重複");
                $gamble = $gamble_chess_num['numbers'];

            //象棋紅黑gamble檢查    
            }else if($input['bet_type']==5){
                $this->roleService->column_validate($input, ['gamble' => 'required|in:0,1']);
                $gamble = $input['gamble'];
            }

        }catch(Exception $e){
            return json_encode(['result'=>0, 'error_code'=>'COLUMN_ERROR',  'error_msg'=>'賭盤ＩＤ或gamble格式錯誤', 'detail'=>$e->getMessage()]);
        }

        $amounts = json_decode($input['amounts'],1);
        if(!is_array($amounts))
            return json_encode(['result'=>0, 'error_code'=>'COLUMN_ERROR',  'error_msg'=>'amounts錯誤', 'detail'=>'非JSON格式']);

        $lines = json_decode($input['line'],1);
        if(!is_array($lines))
            return json_encode(['result'=>0, 'error_code'=>'COLUMN_ERROR',  'error_msg'=>'line錯誤', 'detail'=>'非JSON格式']);


        //下注
        try{

            $user = Auth::guard('web')->user();
            $bet_record_ids = [];

            foreach ($amounts as $key => $value) {
                //檢查下注幣別
                if(!in_array($key, [1,2,3,4]))
                    return json_encode(['result'=>0, 'error_code'=>'COLUMN_ERROR',  'error_msg'=>'amounts錯誤', 'detail'=>'key需為1-4']);
                //檢查下注額是否為整數
                if(!is_int($value))
                    return json_encode(['result'=>0, 'error_code'=>'COLUMN_ERROR',  'error_msg'=>'amounts錯誤', 'detail'=>'value須為整數']);
                //進行下注
                if($value > 0 ){

                    //大小讓分單邊下注值判斷
                    if($input['bet_type']==1 || $input['bet_type']==2){
                        $oneside_bet_check = $this->sportService->check_oneside_bet($input['sport_game_id'],$value,$input['gamble']);
                        if($oneside_bet_check['result']==0){
                            DB::rollBack();
                            return json_encode($oneside_bet_check);
                        }else{
                            if($oneside_bet_check['bet_status']==0){
                                DB::rollBack();
                                return json_encode(['result'=>0, 'error_code'=>'CANNOT_BET',  'error_msg'=>'總下注金額過高', 'detail'=>$oneside_bet_check['bet_amount']]);
                            }
                        }
                    }

                    //下注
                    $bet = $this->sportService->create_sport_bet($sport_game->id, $user->id, $key, $value, $input['bet_type'], $gamble, $input['line']);
                    if($bet['result']==0){
                        DB::rollBack();
                        return json_encode($bet);
                    }
                    array_push($bet_record_ids, $bet['sport_bet_record_id']);
                }
            }

        }catch(Exception $e){

            return json_encode(['result'=>0, 'error_code'=>'DB_ERROR', 'error_msg'=>'DB transaction失敗', 'detail'=>$e->getMessage()]);
        }


        return json_encode(['result'=>1, 'success_msg'=>'下注成功', 'bet_record_ids'=>$bet_record_ids]); 
    }

   


}