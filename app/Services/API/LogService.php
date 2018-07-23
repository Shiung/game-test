<?php
namespace App\Services\API;

use Illuminate\Http\Request;

use App\Models\Account\Account;
use App\Models\Account\TransferAccountRecord;
use App\Models\Account\AccountRecord;
use App\Models\Account\AccountReciveRecord;
use App\Models\Account\AccountRecordTransferRecord;
use App\Models\Parameter;
use App\Models\Member;
use App\Models\Log\AdminActivity;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;
use DB;

class LogService {
	
	public function admin_log($admin_id, $type, $content, $ip=null){

		//更新admin log
		try {
			AdminActivity::create([
				'admin_id' => $admin_id,
				'ip_address' => $ip,
				'type' => $type,
				'content' => $content,
			]);
		}catch(Exception $e){
			return array('result'=>0, 'error_code'=>'LOG_RECORD_FAIL', 'error_msg'=>'admin log寫入失敗', 'detail'=>$e->getMessage());
		}
		
		return array('result'=>1);
	}

}