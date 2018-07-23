<?php
namespace App\Services\API;

use Illuminate\Http\Request;

use App\Services\API\HiNetService;
use App\Services\API\HiNetUtf8Service;
use App\Models\System\SmsConfirmation;
use App\Models\System\Parameter;
use App\Models\Member;
use Exception;

class MobileService {
	protected $hinetService;
    
    public function __construct(HiNetUtf8Service $hinetService)
    {
        
        $this->hinetService =  $hinetService;
        
    }


    //HiNet送簡訊
    public function hinet_send_text($number, $msg){
    	/* Socket to Air Server IP ,Port */
		$server_ip = '202.39.54.130';
		$server_port = 8000;
		$TimeOut=10;

		$user_acc  = "71011429";
		$user_pwd  = "411602d1";
		$mobile_number= $number;
		$message= $msg;


		/*«Ø¥ß³s½u*/
		$mysms = new $this->hinetService;
		$ret_code = $mysms->create_conn($server_ip, $server_port, $TimeOut, $user_acc, $user_pwd);
		$ret_msg = $mysms->get_ret_msg();

		if($ret_code==0){ 
		    $ret_code = $mysms->send_text($mobile_number, $message);
		    $ret_msg = $mysms->get_ret_msg();
		    if($ret_code==0){
		      	return array('result' =>1 , 'success_msg'=>$ret_msg);
		    }else{
		      	return array('result' =>0 , 'error_msg'=>$ret_msg, 'error_code'=>$ret_code,'detail'=>null);
		    }

		//connection error
		} else {  
			return array('result' =>0 , 'error_msg'=>$ret_msg, 'error_code'=>$ret_code,'detail'=>null);
		}

		//disconnect
		$mysms->close_conn();
	}


	//三竹
	public function sms_send($number, $msg)
	{
		$msg = mb_convert_encoding($msg,'big5','utf-8');
        $sms_url = 'http://smexpress.mitake.com.tw:9600/SmSendGet.asp?username=55718604&password=587999&dstaddr='.$number.'&DestName=王先生&dlvtime=10&vldtime=660&smbody='.$msg;
        $result_sms = file_get_contents($sms_url);
        $colume = explode("\r\n", $result_sms);
        $status_code = explode("=",$colume[2]);

        if($status_code[1]>=0 && $status_code[1]<=4)
            $result = ['result' =>1 , 'success_msg'=>'發送簡訊成功', 'statuscode'=>$status_code[1]];
        else
            $result = ['result' =>0 , 'error_code'=>'SEND_FAIL', 'error_msg'=>'發送簡訊失敗', 'detail'=>$status_code[1]];

        return $result;
	}


	//產生簡訊驗證
	public function create($user_id, $number=null){

		//亂數產生code＆id
		$id = md5(rand(100000,999999));
		$code = rand(100000,999999);

		//if id重複 重新產生id&code	
		try {
			SmsConfirmation::findOrFail($id);
			$this->create($user_id,$number);

		//id不重複 寄簡訊
		} catch (Exception $e) {
			try {
			
				//手機號碼	
				if(is_null($number))
					$mobile_number = Member::find($user_id)->phone;
				else
					$mobile_number = $number;
				
				$sms = [
					'id' => $id,
					'code' => $code,
					'member_id' => $user_id
				];
				SmsConfirmation::insert($sms);
			} catch (Exception $e) {
				return array('result' =>0 , 'error_code'=>'DB_ERROR',  'error_msg'=>'sms table寫入失敗', 'detail'=>$e->getMessage(), 'id'=>$id);
			}

			//寄code簡訊
			$msg = "來自".env("COMPANY_NAME")."的簡訊驗證碼：".$code;

			//hinet
			if(env("SMS_SERVER")=='hinet')
				$hinet_result = $this->hinet_send_text($mobile_number,$msg);

			//三竹
			if(env("SMS_SERVER")=='san_chu')
				$hinet_result = $this->sms_send($mobile_number,$msg);
			
			if($hinet_result['result']==1)
				return array('result' =>1 , 'id'=>$id);
			else
				return $hinet_result;
		}

	}


	//簡訊驗證
	public function auth($id, $code){

		try {
			$sms = SmsConfirmation::findOrFail($id);
			$expire_second = Parameter::where('name','sms_expire_second')->first()->value;
			$sms_time = strtotime($sms->created_at);
			$expire_time =  $expire_second+$sms_time;
			$now = strtotime("now");
			
			//驗證碼錯誤
			if($sms->code != $code) {
				return array('result'=>0, 'error_code'=>'ERROR_CODE', 'error_msg'=>'驗證碼錯誤' , 'id'=>$id, 'detail'=>null);

			//驗證碼過期 刪除舊紀錄,重新產生驗證碼
			}else if($expire_time - $now < 0){

				$user_id = $sms->member_id;
				$sms->delete();
				$result = $this->create($user_id);

				if($result['result']==1)
					return array('result'=>0,  'error_code'=>'EXPIRE_CODE', 'error_msg'=>'驗證碼過期' , 'id'=>$result['id'],'detail'=>null);
				else
					return $result;

			//驗證成功 清除驗證紀錄		
			}else{
				$sms->delete();
				return array('result'=>1, 'success_msg'=>'驗證成功' , 'id'=>$id);
			}


		} catch (Exception $e) {
			return array('result'=>0, 'error_code'=>'ERROR_ID','error_msg'=>'無此驗證id', 'id'=>$id, 'detail'=>$e->getMessage());
		}

	}

}