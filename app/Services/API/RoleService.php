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
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\MemberLevelRecord;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;
use Validator;
use DB;


class RoleService {
	
	//管理員權限判斷
	public function admin_permission($admin_id, $role)
	{
		
		$role_names = ['super-admin','master-admin'];
		array_push($role_names, $role);
		$roles = RoleUser::where('user_id',$admin_id)->whereIn('role_id', function($q) use ($role_names){
															$q->select('id')->from('roles')->whereIn('name',$role_names);
														})->get();

		if($roles->isEmpty())
			return array('result'=>0, 'error_code'=>'PERMISSION_DENY', 'error_msg'=>'無此操作管理權限', 'detail'=>null);
		else
			return array('result'=>1);
	}


	//request validation
	public function column_validate($request, $validate, $error_msg='POST欄位有誤')
	{
		$validator = Validator::make($request, $validate);
        if ($validator->fails()) {
			header('Content-Type: application/json');
            echo json_encode(['result'=>0, 'error_code'=>'COLUMN_MISS',  'error_msg'=>$error_msg, 'detail'=>$validator->errors()]);
            exit();
        }
	}


	//管理員權限判斷
	public function admin_permission_check($token, $role)
	{
		$user = JWTAuth::toUser($token);
        $permission = $this->admin_permission($user->id,$role);
        if($permission['result']==0){
			header('Content-Type: application/json');
            echo json_encode($permission);
            exit();
        }else{
        	return $user;
        }
	}


	//會員等級
	public function member_level($member_id)
	{
		$levels = MemberLevelRecord::select(DB::raw('SUM(day_count) as days, member_id, member_level_id, MIN(member_level_records.created_at) as start_datetime, expired_status, interest'))
									->where('member_id', $member_id)->where('expired_status',0)
									->join('product_member_levels','member_level_id','=','product_member_levels.product_id')
									->groupBy('member_level_id')
									->orderBy('interest','desc')
									->get();
		//print_r(MemberLevelRecord::getQueryLog());
		//print_r($levels);
		foreach ($levels as $level) {

			if(!is_null($level->days)){
				$start_date = strtotime($level->start_datetime);
				$expire_time = strtotime('+'.$level->days.' days', $start_date);
				$now = strtotime("now");
				$less_second = $expire_time - $now;

				//沒過期 直接回傳會員等級結果
				if($less_second > 0){
					$expire_date = date("Y-m-d H:i:s",$expire_time);
					return array('result'=>1, 'success_msg'=>'查詢會員等級成功', 'member_id'=>$member_id, 'member_level_id'=>$level->member_level_id, 'interest'=>$level->interest, 'expire_date'=>$expire_date);
				}

			}else if($level->member_id == $member_id){
				return array('result'=>1, 'success_msg'=>'查詢會員等級成功', 'member_id'=>$member_id, 'member_level_id'=>$level->member_level_id, 'interest'=>$level->interest, 'expire_date'=>null);
			}

		}
		
		return array('result'=>0, 'error_code'=>'NULL_LEVEL', 'error_msg'=>'該會員目前沒有任何會員等級', 'detail'=>null);
	}

	

}