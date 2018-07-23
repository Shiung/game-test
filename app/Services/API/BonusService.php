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
use App\Models\Tree;
use App\Models\Shop\ProductMemberLevel;
use App\Models\Sport\SportBetRecord;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Services\API\PluginService;
use App\Services\API\AccountService;
use App\Services\API\RoleService;
use App\Services\API\TreeService;
use App\Services\API\StatService;
use Exception;
use Validator;
use DB;


class BonusService {
	
	protected $pluginService;
	protected $accountService;
	protected $roleService;
	protected $treeService;
	protected $statService;

	public function __construct(PluginService $pluginService, AccountService $accountService, RoleService $roleService, TreeService $treeService, StatService $statService)
	{
		$this->pluginService = $pluginService;
		$this->accountService = $accountService;
		$this->roleService = $roleService;
		$this->treeService = $treeService;
		$this->statService = $statService;
	}


	//會員卡回饋
	public function member_card_feedback($card_user_id, $product_id)
	{
		try{
			$product = ProductMemberLevel::findOrFail($product_id);
			$use_member = Member::findOrFail($card_user_id);

			//回饋給使用者 丟到簽到中心
			if($product->member_feedback >0 ){
				$description = '[好友獎金]'.$product->product->name.'使用回饋：'.$product->member_feedback;
				$this->add_money_to_receive_center($use_member->user_id, 2, $product->member_feedback, $product->feedback_period, $description);
			}

			//回饋給推薦者 丟到簽到中心
			if(!is_null($use_member->recommender_id)  && $product->recommender_feedback >0 ){
				$description = '[好友獎金]'.$product->product->name.'使用回饋：'.$product->recommender_feedback;
				$this->add_money_to_receive_center($use_member->recommender_id, 2, $product->recommender_feedback, $product->feedback_period, $description);
			}

		}catch(Exception $e){
            return array('result'=>0, 'error_code'=>'DB_ERROR', 'error_msg'=>'回饋DB transcation失敗', 'detail'=>$e->getMessage());
		}

		return array('result' => 1);

	}


	//會員每天生利息
	public function member_daily_interest()
	{
		try{
			$member_ids = [];
			$members = Member::all();
			foreach ($members as $member) {
				//查詢會員等級
				$level = $this->roleService->member_level($member->user_id);
				if($level['result']==0)
					return $level;
				//查詢權力馬餘額
				$member_share_amount = $this->accountService->share_account_balance($member->user_id);

				//產生利息
				$daily_interest = floor($member_share_amount*$level['interest']/30);
				//echo ($member_share_amount*$level['interest']/30)." ";
				$description = '[每日紅利]'.$member_share_amount.'*'.$level['interest'].'/30='.$daily_interest;
				$period = Parameter::where('name','daily_interest_period')->firstOrFail()->value;

				//丟到簽到中心
				if($daily_interest>0){
					$this->add_money_to_receive_center($member->user_id, 4, $daily_interest, $period, $description);
				}
				array_push($member_ids, $member->user_id);
			}

		}catch(Exception $e){
			return array('result'=>0, 'error_code'=>'DB_ERROR', 'error_msg'=>'每日紅利產生失敗', 'detail'=>$e->getMessage(), 'member_ids'=>$member_ids);
		}

		return array('result' => 1, 'member_ids'=>$member_ids);
	}


	//每月產生 有效下注投注獎金
	public function bet_monthly_bonus()
	{
		try{
			$member_ids = [];
			$members = Member::all();
			$bet_bonus_level = Parameter::where('name','bet_bonus_level')->firstOrFail()->value;
			$bet_bonus_interest = Parameter::where('name','bet_bonus_interest')->firstOrFail()->value;
			$bet_bonus_period = Parameter::where('name','bet_bonus_period')->firstOrFail()->value;

			//上個月1號 <= x < 這個月1號
			$start_date = date("Y-m-d",strtotime("first day of last month"));
			$end_date = date("Y-m")."-01";
			//$start_date = "2017-10-01";
			//$end_date = "2017-11-01";

			foreach ($members as $member) {
				$has_member = Tree::where('parent_id',$member->user_id)->get();
				if(!$has_member->isEmpty()){
					//產生所有下線id
					$this->treeService->createtree($member->user_id, $bet_bonus_level);
					//print_r($this->treeService->treelist);
					//找到下線的所有下注單
					$member_bet_records = SportBetRecord::where('sport_bet_records.created_at','>=',$start_date)
											->where('sport_bet_records.created_at','<',$end_date)
					   						->join('accounts','accounts.id','=','sport_bet_records.account_id')
					   						->whereIn('accounts.type',[1,3])
											->whereIn('sport_bet_records.member_id',$this->treeService->treelist["member"])
											->get();
					//有效下注總和
					$member_real_bet_amount = $member_bet_records->sum('real_bet_amount');
				}else{
					$member_real_bet_amount = 0;
				}
				//找到自己的所有下注單
				$self_bet_records = SportBetRecord::where('sport_bet_records.created_at','>=',$start_date)
											->where('sport_bet_records.created_at','<',$end_date)
											->where('sport_bet_records.member_id', $member->user_id)
											->join('accounts','accounts.id','=','sport_bet_records.account_id')
					   						->whereIn('accounts.type',[1,3])
											->get();
				//有效下注總和
				$self_real_bet_amount = $self_bet_records->sum('real_bet_amount');
				
				$real_bet_amount = $self_real_bet_amount+$member_real_bet_amount;
				$bonus = floor($real_bet_amount*$bet_bonus_interest);
				$description = '[投注獎金]'.$real_bet_amount.'*'.$bet_bonus_interest.'='.$bonus;


				//丟到簽到中心
				if($bonus>0){
					$this->add_money_to_receive_center($member->user_id, 2, $bonus, $bet_bonus_period, $description);
				}

				array_push($member_ids, $member->user_id);
			}

		}catch(Exception $e){
			return array('result'=>0, 'error_code'=>'DB_ERROR', 'error_msg'=>'投注獎金產生失敗', 'detail'=>$e->getMessage(), 'member_ids'=>$member_ids);
		}

		return array('result' => 1, 'member_ids'=>$member_ids);
	}


	//每日親推利息
	public function recommender_interest()
	{
		try{
			$member_ids = [];
			$members = Member::all();
			$start_date = date("Y-m-d",strtotime("-1 days"));
			$end_date = date("Y-m-d");

			$recommend_bonus_interest = Parameter::where('name','recommend_bonus_interest')->firstOrFail()->value;
			$recommend_bonus_period = Parameter::where('name','recommend_bonus_period')->firstOrFail()->value;

			foreach ($members as $member) {
				$recommender_ids = $this->treeService->find_recommenders($member->user_id);
				$receive_interest = $this->statService->receive_center($start_date, $end_date, [3], [4],$recommender_ids);

				//計算親推利息
				if(!is_null($receive_interest->amount)){
					//echo $receive_interest->amount."///";
					$bonus = floor($receive_interest->amount*$recommend_bonus_interest);
					$description = '[好友紅利]'.$receive_interest->amount.'*'.$recommend_bonus_interest.'='.$bonus;

					//丟到簽到中心
					if($bonus>0){
						$this->add_money_to_receive_center($member->user_id, 2, $bonus, $recommend_bonus_period, $description);
					}
				}

				array_push($member_ids, $member->user_id);
			}

		}catch(Exception $e){
			return array('result'=>0, 'error_code'=>'DB_ERROR', 'error_msg'=>'好友紅利產生失敗', 'detail'=>$e->getMessage(), 'member_ids'=>$member_ids);
		}

		return array('result' => 1, 'member_ids'=>$member_ids);
	}


	//每月組織利息
	public function tree_interest()
	{
		try{
			$member_ids = [];
			$members = Member::all();
			$start_date = date("Y-m-d",strtotime("first day of last month"));
			$end_date = date("Y-m")."-01";

			$tree_bonus_interest = Parameter::where('name','tree_bonus_interest')->firstOrFail()->value;
			$tree_bonus_period = Parameter::where('name','tree_bonus_period')->firstOrFail()->value;
			$tree_bonus_level = Parameter::where('name','tree_bonus_level')->firstOrFail()->value;

			foreach ($members as $member) {
				$has_member = Tree::where('parent_id',$member->user_id)->get();

				//如果有下線
				if(!$has_member->isEmpty()){
					//產生所有下線id
					$this->treeService->createtree($member->user_id, $tree_bonus_level);
					//找出下線在領取中心領的利息
					$receive_interest = $this->statService->receive_center($start_date, $end_date, [3], [4],$this->treeService->treelist["member"]);

					//計算組織利息
					if(!is_null($receive_interest->amount)){
						//echo $receive_interest->amount."///";
						$bonus = floor($receive_interest->amount*$tree_bonus_interest);
						$description = '[社群紅利]'.$receive_interest->amount.'*'.$tree_bonus_interest.'='.$bonus;

						//丟到簽到中心
						if($bonus>0){
							$this->add_money_to_receive_center($member->user_id, 2, $bonus, $tree_bonus_period, $description);
						}
					}
				}

				array_push($member_ids, $member->user_id);
			}

		}catch(Exception $e){
			return array('result'=>0, 'error_code'=>'DB_ERROR', 'error_msg'=>'社群紅利產生失敗', 'detail'=>$e->getMessage(), 'member_ids'=>$member_ids);
		}

		return array('result' => 1, 'member_ids'=>$member_ids);
	}


	//新增錢至簽到中心
	public function add_money_to_receive_center($member_id, $account_type, $amount, $day_count, $description)
	{
		//echo $member_id;
		$account = Account::where('member_id',$member_id)->where('type',$account_type)->firstOrFail();
		AccountReceiveRecord::create([
			'member_id' => $member_id,
			'account_id' => $account->id,
			'amount' => $amount,
			'status' => 0,
			'day_count' => $day_count,
			'description' => $description,
		]);
	}


	//從簽到中心拿錢
	public function get_money_from_receive_center($id)
	{
		$center_record = AccountReceiveRecord::lockForUpdate()->findOrFail($id);
		$expire = $this->pluginService->expire_check($center_record->day_count, $center_record->created_at);
		
		if($expire['status']==1)
			return array('result'=>0, 'error_code'=>'EXPIRED', 'error_msg'=>'此物品已過期', 'detail'=>'到期日：'.$expire['expire_date']);

		//領取
		//判斷是否超出權利碼餘額
		$receive_share_account = $this->accountService->share_account_balance($center_record->member_id);
		if($center_record->amount > $receive_share_account)
			$receive_amount = $receive_share_account;
		else
			$receive_amount = $center_record->amount;

		$description = $center_record->description.'(領取當下娛樂幣帳戶餘額:'.$receive_share_account.')';

		//轉帳
		$result = $this->accountService->transfer(null, $center_record->member_id, $center_record->account->type, $receive_amount, 0,3,$description);
		if($result['result']==0)
			return $result;

		//更新簽到中心紀錄
		$center_record->update([
			'status' => 1,
		]);

		return array('result'=>1);
	}




}