<?php
namespace App\Services\API;

use Illuminate\Http\Request;

use App\Models\Account\Account;
use App\Models\Account\TransferAccountRecord;
use App\Models\Account\AccountRecord;
use App\Models\Account\AccountReceiveRecord;
use App\Models\Account\AccountRecordTransferRecord;
use App\Models\Parameter;
use App\Models\Member;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\MemberLevelRecord;
use App\Models\Shop\ProductMemberLevel;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;
use Validator;
use DB;


class PluginService {
	
	//過期判斷
	public function expire_check($period_days, $start_date)
	{
		
		if(!is_null($period_days)){
            $start_time = strtotime($start_date);
            $expire_time = strtotime('+'.$period_days.' days', $start_time);
            $now = strtotime("now");
            $less_second = $expire_time - $now;
            $expire_date = date("Y-m-d H:i:s",$expire_time);

            //過期
            if($less_second <= 0){
            	return array('status'=>1, 'expire_date'=>$expire_date);
            //沒過期
            }else{
            	return array('status'=>0, 'expire_date'=>$expire_date);
            }
        //永不過期
        }else{
        	return array('status'=>0, 'expire_date'=>null);
        }
	}

    //過期判斷
    public function bet_closetime_check($period_seconds, $start_date)
    {
        
        if(!is_null($period_seconds)){
            $start_time = strtotime($start_date);
            $expire_time = strtotime('-'.$period_seconds.' seconds', $start_time);
            $now = strtotime("now");
            $less_second = $expire_time - $now;
            $expire_date = date("Y-m-d H:i:s",$expire_time);

            //過期 關閉下注
            if($less_second <= 0){
                return array('status'=>1, 'expire_date'=>$expire_date);
            //沒過期
            }else{
                return array('status'=>0, 'expire_date'=>$expire_date);
            }
        //永不過期
        }else{
            return array('status'=>0, 'expire_date'=>null);
        }
    }


    //象棋排程時間點計算
    public function chess_schedule()
    {
        try{
            $cn_chess_interval = Parameter::where('name','cn_chess_interval')->firstOrFail()->value;
            $cn_chess_resttime = Parameter::where('name','cn_chess_resttime')->firstOrFail()->value;

            $chess_interval = $cn_chess_interval*60;
            $chess_resttime = $cn_chess_resttime;
            $close_bet = 10;

            //計算每小時 象棋開盤時間
            $times = 3600/$chess_interval;
            if(!is_int($times))
                return array('result'=>0, 'error_msg'=>'開獎區間秒數需為3600的因數', 'error_code'=>'INTERVAL_ERROR', 'detail'=>null);
            
            $open_time = ['sec'=>[0=>(60-$close_bet)], 'min'=>[0=>(60-ceil($close_bet/60))]];  //開獎時間
            $create_time = [];  //開盤時間

            for($i=1;$i<=$times;$i++){
                //計算開獎時間 0分0秒必開
                if($i!=$times){
                    $second = ($chess_interval*$i-$close_bet)%60;
                    $minute = floor(($chess_interval*$i-$close_bet)/60);
                    $open_time['sec'][$i] = $second;
                    $open_time['min'][$i] = $minute;
                }
                
                //計算開盤時間
                $create_seconds = $chess_interval*($i-1) + $chess_resttime;
                $create_sec = $create_seconds%60;
                $create_min = floor($create_seconds/60);
                if($i!=$times){
                    $create_time['sec'][$i] = $create_sec;
                    $create_time['min'][$i] = $create_min;
                }
                else{
                    $create_time['sec'][0] = $create_sec;
                    $create_time['min'][0] = $create_min;
                }
            }

            //轉成cron格式
            $open_cron_sec = collect($open_time['sec'])->unique()->implode(',');
            $open_cron_min = collect($open_time['min'])->unique()->implode(',');
            $open_cron = $open_cron_sec." ".$open_cron_min." * * *";

            $create_cron_sec = collect($create_time['sec'])->unique()->implode(',');
            $create_cron_min = collect($create_time['min'])->unique()->implode(',');
            $create_cron = $create_cron_sec." ".$create_cron_min." * * *";

        }catch (Exception $e){
            return response()->json(['result'=>0, 'error_code'=>'ERROR',  'error_msg'=>'象棋排程時間點計算失敗','detail'=>$e->getMessage()]);
        }

        return array('result'=>1, 'open_cron'=>$open_cron, 'create_cron'=>$create_cron, 'open_time'=>$open_time, 'create_time'=>$create_time);
    }

}