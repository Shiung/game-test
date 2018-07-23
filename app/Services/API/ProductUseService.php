<?php
namespace App\Services\API;

use Illuminate\Http\Request;

use App\Models\Account\Account;
use App\Models\Account\TransferAccountRecord;
use App\Models\Account\AccountRecord;
use App\Models\Account\AccountReciveRecord;
use App\Models\Account\AccountRecordTransferRecord;
use App\Models\Shop\Product;
use App\Models\Shop\ProductMemberLevel;
use App\Models\Shop\ProductBag;
use App\Models\Shop\Transaction;
use App\Models\Shop\ProductUseRecord;
use App\Models\Shop\Withdrawal;
use App\Models\Parameter;
use App\Models\Member;
use App\Models\MemberLevelRecord;
use App\Models\User;
use App\Models\Tree;
use App\Services\API\TreeService;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Services\API\AccountService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DB;

class ProductUseService {

	protected $accountService;
	protected $treeService;
    
    public function __construct(AccountService $accountService, TreeService $treeService)
    {
        
        $this->accountService =  $accountService;
        $this->treeService = $treeService;
        
    }
	
	
	//使用道具
	public function use_product($member_id, $product_id, $quantity)
	{
		//確認id正確性
		try{
			$bag = ProductBag::where('member_id',$member_id)->where('product_id', $product_id)->lockForUpdate()->firstOrFail();
		}catch(Exception $e){
            return array('result'=>0, 'error_code'=>'COLUMN_ERROR',  'error_msg'=>'背包沒有此商品', 'detail'=>$e->getMessage());
		}

		//確認商品數量
		if($bag->quantity < $quantity)
            return array('result'=>0, 'error_code'=>'NOT_ENOUGH',  'error_msg'=>'背包商品數量不足', 'detail'=>'商品剩餘數量：'.$bag->quantity);

        //減少背包商品數量
        try{
	        $new_quantity = $bag->quantity - $quantity;
	        if($new_quantity == 0){
	        	$bag->delete();
	        }else{
	        	$bag->update([
	        		'quantity' => $new_quantity,
	        	]);
	        }

	        //使用紀錄
	        ProductUseRecord::create([
	        	'member_id' => $member_id,
	        	'product_id' => $product_id,
	        	'quantity' => $quantity,
	        ]);

	    }catch(Exception $e){
            return array('result'=>0, 'error_code'=>'DB_ERROR', 'error_msg'=>'背包DB transcation失敗', 'detail'=>$e->getMessage());
	    }

        return array('result'=>1);	
	}


	//使用會員卡
	public function member_card($product_id, $member_id)
	{
		try{
			$member_level = ProductMemberLevel::findOrFail($product_id);
		}catch(Exception $e){
            return array('result'=>0, 'error_code'=>'COLUMN_ERROR',  'error_msg'=>'沒有此張VIP卡', 'detail'=>$e->getMessage());
		}

		//已有使用相同會員卡 更新級別有效時間
		try{
			$level_record = MemberLevelRecord::where('expired_status',0)->where('member_level_id',$product_id)->where('member_id',$member_id)->firstOrFail();
			$new_day_count = $level_record->day_count + $member_level->period;
			$level_record->update(['day_count' => $new_day_count]);

		//目前沒有使用此會員卡 新增級別
		}catch(Exception $e){
			MemberLevelRecord::create([
				'member_id' => $member_id,
				'member_level_id' => $product_id,
				'day_count' => $member_level->period,
				'expired_status' => 0,
			]);
		}	
		

		return array('result'=>1);
	}


	//使用推薦卡 新增會員
	public function recommender_card_addmember($username, $password, $name, $bank_code, $bank_account, $recommender_id)
	{
		try{
			$user = User::create([
				'username' => $username,
				'password' => $password,
				'login_permission' => 1,
				'pwd_wrong_count' => 0,
				'type' => 'member',
			]);

			$member_number = date("Ymd").str_pad($user->id, 5, '0', STR_PAD_LEFT);
			$member = Member::create([
				'user_id' => $user->id,
				'member_number' => $member_number,
				'name' => $name,
				'bank_code' => $bank_code,
				'bank_account' => $bank_account,
				'recommender_id' => $recommender_id,
			]);

			//開帳戶
			$create_acc = $this->accountService->create_accounts($user->id);
			if($create_acc['result']==0)
				return $create_acc;

		}catch(Exception $e){
            return array('result'=>0, 'error_code'=>'DB_ERROR',  'error_msg'=>'新增會員失敗', 'detail'=>$e->getMessage());

		}
		return array('result'=>1, 'user_id'=>$user->id);
	}


	//使用推薦卡 安置會員
	public function recommender_card_addnode($recommender_id, $parent_id, $member_id, $position)
	{
		
		//檢查安置位置是否為空
		$node_check = Tree::where('parent_id',$parent_id)->where('position',$position)->first();
		if($node_check)
			return array('result'=>0, 'error_code'=>'TREE_ERROR', 'error_msg'=>'此位置已有會員被安置', 'detail'=>null);

		//檢查會員有沒有在tree
		$member_check = Tree::find($member_id);
		if($member_check)
			return array('result'=>0, 'error_code'=>'TREE_ERROR', 'error_msg'=>'會員已被安置', 'detail'=>null);
	
		//檢查接點人有沒有在tree
		$parent_check = Tree::find($parent_id);
		if(!$parent_check)
			return array('result'=>0, 'error_code'=>'TREE_ERROR', 'error_msg'=>'接點人未被安置', 'detail'=>null);

		//檢查parent是不是recommender的下線
		if($recommender_id != $parent_id){
			$check = $this->treeService->checkTree($parent_id, $recommender_id);
			if($check['result']==0)
				return array('result'=>0, 'error_code'=>'TREE_ERROR', 'error_msg'=>'接點人非推薦人之下線', 'detail'=>null);
		}
		
		//位置為空 進行安置
		Tree::create([
			'member_id' => $member_id,
			'parent_id' => $parent_id,
			'position' => $position,
		]);

		//修改會員安置狀態
		$member = Member::find($member_id);
		$member->update([
			'place_status' => 1,
			'placed_at' => date("Y-m-d H:i:s"),
		]);
		
		return array('result'=>1);
			
	}


	//使用轉帳卡 出金申請
	public function transfer_card_withdraw($member_id, $amount)
	{
		try{
			$withdraw = Withdrawal::create([
				'member_id' => $member_id,
				'amount' => $amount,
				'confirm_status' => 0,
			]);
		}catch (Exception $e){
            return array('result'=>0, 'error_code'=>'DB_ERROR',  'error_msg'=>'群發紅包申請失敗', 'detail'=>$e->getMessage());
		}
		
		return array('result'=>1, 'id'=>$withdraw->id);

	}
}