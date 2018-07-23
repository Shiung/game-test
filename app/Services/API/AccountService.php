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
use App\Models\Shop\Withdrawal;
use App\Models\Shop\Share;
use App\Models\Shop\ShareRecord;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;
use DB;

class AccountService {



    //開帳戶
    public function create_accounts($member_id)
    {
        for($i=1;$i<=5;$i++){
        	try{
				$account = Account::where('member_id',$member_id)->where('type',$i)->firstOrFail();
			}catch(Exception $e){
				try{
					Account::create([
						'member_id' => $member_id,
						'type' => $i,
					]);
				}catch(Exception $e){
					return array('result'=>0, 'error_code'=>'DB_ERROR', 'error_msg'=>'新增帳戶失敗', 'detail'=>$e->getMessage());
				}
			}
        }
        return array('result' => 1 );
    }


	//現金碼可用餘額
	public function virtual_cash_balance($member_id)
	{
		try{
			$account = Account::where('member_id',$member_id)->where('type',1)->firstOrFail();
			//未確認出金金額
			/*
			$withdrawals = Withdrawal::where('member_id',$member_id)->where('confirm_status',0)->get();
			$sum = $withdrawals->sum('amount');
			return ($account->amount - $sum);
			*/
			return $account->amount;
		}catch(Exception $e){
			return $e->getMessage();
		}
	}


	//權利碼可用餘額
	public function share_account_balance($member_id)
	{
		$account = Account::where('member_id',$member_id)->where('type',3)->first();
		return $account->amount;
	}


	//利息馬每日清空
	public function clear_interest_account()
	{
		$accounts = Account::where('type',4)->where('amount','>',0)->get();
		$member_ids = [];
		foreach ($accounts as $account) {
			$description = '每日回收紅利點數帳戶餘額';
			$t = $this->transfer($account->member_id,null,$account->type,$account->amount,0,13,$description);
			if($t['result']==0){
				$t['finish_user_id'] = $member_ids;
				return $t;
			}
			array_push($member_ids, $account->member_id);
		}
		return array('result'=>1, 'finish_user_id' => $member_ids);
	}


	//會員購買權利碼
	public function member_share_buy($transaction_id, $amount, $type='member_buy')
	{
		$share = Share::lockForUpdate()->first();
		$remain_share = $share->all_share - $share->sell_share;
		$new_share = $remain_share - $amount;

		if($new_share < 0)
			return array('result'=>0, 'error_code'=>'SHARE_NOT_ENOUGH', 'error_msg'=>'剩餘的娛樂幣不夠買/移轉', 'detail'=>$remain_share);

		//權利碼變動
		$share_record = ShareRecord::create([
			'amount' => -$amount,
			'total' => $new_share,
			'transaction_id' => $transaction_id,
			'type' => $type,
		]);

		$share->update([
			'sell_share' => $share->sell_share + $amount,
		]);

		return array('result'=>1, 'share_record_id'=>$share_record->id);
	}


	//發行減少權利碼
	public function company_share_modify($amount)
	{
		$share = Share::lockForUpdate()->first();
		$remain_share = $share->all_share - $share->sell_share;
		$new_share = $remain_share + $amount;

		if($new_share < 0)
			return array('result'=>0, 'error_code'=>'SHARE_NOT_ENOUGH', 'error_msg'=>'剩餘的娛樂幣不夠收回', 'detail'=>$remain_share);
		
		//權利碼變動
		$share_record = ShareRecord::create([
			'amount' => $amount,
			'total' => $new_share,
			'transaction_id' => null,
			'type' => 'company_add',
		]);

		$share->update([
			'all_share' => $share->all_share + $amount,
		]);

		return array('result'=>1, 'share_record_id'=>$share_record->id);

	}


	//會員購買專屬權利碼
	public function member_exclusive_share_buy($member_id, $amount)
	{
		$exclusive_account = Account::where('member_id',$member_id)->where('type',5)->lockForUpdate()->firstOrFail();
		if($amount > $exclusive_account->amount)
			return array('result'=>0, 'error_code'=>'EXCLUSIVE_NOT_ENOUGH', 'error_msg'=>'剩餘的專屬娛樂幣不夠買', 'detail'=>$exclusive_account->amount);

		//轉出專屬權利碼
		$result = $this->transfer($member_id,null,5,$amount,0,10,'購買專屬娛樂幣');
		if($result['result']==0)
			return $result;

		return array('result'=>1);
	}


	//出金確認或拒絕
	public function withdraw_confirm($id, $status, $admin_id)
	{
		$withdraw = Withdrawal::lockForUpdate()->find($id);

		//拒絕的話要退錢
		if($status==2){
			$result = $this->transfer(null,$withdraw->member_id,1,$withdraw->amount,0,8,'申請單＃'.$id.' 被拒絕，進行退款');
			if($result['result']==0)
				return $result;
		}

		//修改狀態
		$withdraw->update([
			'confirm_admin_id' => $admin_id,
			'confirm_status' => $status,
			'confirm_at' => date("Y-m-d H:i:s"),
		]);
		return array('result' => 1 ); 
	}

	
	//轉帳
	public function transfer($transfer,$receive,$account_type,$amount,$fee,$transfer_type,$description,$receive_fee=0)
	{

		//DB::beginTransaction();

		//找到帳戶id
		try{
			if(is_null($transfer)){
				$transfer_account_id = null;
			}elseif ($transfer == 'company') {
				$transfer_account_id = null;
				$transfer = null;
			}else{
				$transfer_account = Account::where('member_id',$transfer)->where('type',$account_type)->lockForUpdate()->firstOrFail();
				$transfer_account_id = $transfer_account->id;
			}

			if(is_null($receive)){
				$receive_account_id = null;
			}elseif ($receive == 'company') {
				$receive_account_id = null;
				$receive = null;
			}else{
				$receive_account = Account::where('member_id',$receive)->where('type',$account_type)->lockForUpdate()->firstOrFail();
				$receive_account_id = $receive_account->id;
			}
		}catch(Exception $e){
			//DB::rollBack();
			return array('result'=>0, 'error_code'=>'WRONG_ACCOUNT', 'error_msg'=>'找不到會員之帳戶', 'detail'=>$e->getMessage());
		}

		try{			
			//轉帳記錄
			$transfer_record = TransferAccountRecord::create([
									'transfer_amount' => $amount,
									'transfer_member_id' => $transfer,
									'transfer_account_id' => $transfer_account_id,
									'receive_member_id' => $receive,
									'receive_account_id' => $receive_account_id,
									'receive_amount' => $amount,
									'transfer_fee' => $fee,
									'receive_fee' => $receive_fee,
									'type' => $transfer_type,
									'description' => $description,
								]);

			//transfer帳戶變動
			if(!is_null($transfer)){

				//判斷transfer帳戶還有沒有錢
				/////帳戶餘額
				if($account_type==1)
					$transfer_account_balance = $this->virtual_cash_balance($transfer);
				else
					$transfer_account_balance = $transfer_account->amount;
				////轉帳總額
				$transfer_total = $amount + $fee;
				if($transfer_account_balance < $transfer_total)
					throw new Exception("Insufficient_balance");

				$transfer_account_record = AccountRecord::create([
					'account_id' => $transfer_account_id,
					'amount' => -$amount,
					'description' => $description,
					'type' => $transfer_type,
					'total' => $transfer_account->amount - $amount,
				]);
				$transfer_account->update(['amount' => ($transfer_account->amount - $amount)]);
				//關聯
				AccountRecordTransferRecord::create([
					'a_record_id' => $transfer_account_record->id,
					't_record_id' => $transfer_record->id,
				]);

				//手續費
				if($fee>0){
					$transfer_account_fee = Account::lockForUpdate()->find($transfer_account_id);
					$transfer_account_record_fee = AccountRecord::create([
						'account_id' => $transfer_account_id,
						'amount' => -$fee,
						'description' => '手續費#'.$transfer_record->id."(".$description.")",
						'type' => 5,
						'total' => $transfer_account_fee->amount - $fee,
					]);
					$transfer_account_fee->update(['amount' => ($transfer_account_fee->amount - $fee)]);
					//關聯
					AccountRecordTransferRecord::create([
						'a_record_id' => $transfer_account_record_fee->id,
						't_record_id' => $transfer_record->id,
					]);
				}
			}

			//receive帳戶變動
			if(!is_null($receive)){
				$receive_account_record = AccountRecord::create([
					'account_id' => $receive_account_id,
					'amount' => $amount,
					'description' => $description,
					'type' => $transfer_type,
					'total' => $receive_account->amount + $amount,
				]);
				$receive_account->update(['amount' => ($receive_account->amount + $amount)]);
				//關聯
				AccountRecordTransferRecord::create([
						'a_record_id' => $receive_account_record->id,
						't_record_id' => $transfer_record->id,
					]);

				//手續費
				if($receive_fee>0){
					$receive_account_fee = Account::lockForUpdate()->find($receive_account_id);
					$receive_account_record_fee = AccountRecord::create([
						'account_id' => $receive_account_id,
						'amount' => -$receive_fee,
						'description' => '手續費#'.$transfer_record->id."(".$description.")",
						'type' => 5,
						'total' => $receive_account_fee->amount - $receive_fee,
					]);
					$receive_account_fee->update(['amount' => ($receive_account_fee->amount - $receive_fee)]);
					//關聯
					AccountRecordTransferRecord::create([
						'a_record_id' => $receive_account_record_fee->id,
						't_record_id' => $transfer_record->id,
					]);
				}
			}


		}catch (Exception $e){
			//DB::rollBack();
			if($e->getMessage()=='Insufficient_balance')
				return array('result'=>0, 'error_code'=>'INSUFFICIENT_BALANCE', 'error_msg'=>'轉出帳戶餘額不足', 'detail'=>$e->getMessage());
			else
				return array('result'=>0, 'error_code'=>'DB_ERROR', 'error_msg'=>'發紅包DB transcation失敗', 'detail'=>$e->getMessage());
		}

		//DB::commit();
		return array('result'=>1, 'success_msg'=>'發紅包成功', 'transfer_record_id'=>$transfer_record->id);

	}
}