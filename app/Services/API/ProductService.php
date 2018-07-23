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
use App\Models\Parameter;
use App\Models\Member;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Services\API\AccountService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DB;

class ProductService {

	protected $accountService;
    
    public function __construct(AccountService $accountService)
    {
        
        $this->accountService =  $accountService;
        
    }
	
	//insert product table
	public function create_product($name, $category_id, $price, $quantity, $subtract, $description)
	{
		$product = Product::create([
			'name' => $name,
			'product_category_id' => $category_id,
			'price' => $price,
			'status' => 0,
			'quantity' => $quantity,
			'subtract' => $subtract,
			'description' => $description,
		]);

		return $product;
	}


	//insert product_member_levels(會員卡or推薦卡)
	public function create_product_member_levels($product_id, $register, $interest, $member_feedback, $recommender_feedback, $feedback_period, $period, $tree_name)
	{
		$product_member_level = ProductMemberLevel::create([
			'product_id' => $product_id,
			'register' => $register,
			'interest' => $interest,
			'member_feedback' => $member_feedback,
			'recommender_feedback' => $recommender_feedback,
			'feedback_period' => $feedback_period,
			'period' => $period,
			'tree_name' => $tree_name,
		]);

		return $product_member_level;
	}


	//購買商品
	public function buy($product_id, $member_id, $quantity, $addin_bag=1)
	{
		//查看商品是否上架
		try{
			$product = Product::lockForUpdate()->findOrFail($product_id);
			if($product->status==0)
				throw new Exception("此商品已下架");
		}catch(Exception $e){
			return array('result'=>0, 'error_code'=>'PRODUCT_NOT_FIND', 'error_msg'=>'找不到此商品或商品已下架', 'detail'=>$e->getMessage());
		}

		try{
			//庫存管理
			$stock = $this->subtract_minus($product, $quantity);
			if($stock==0)
				return array('result'=>0, 'error_code'=>'STOCK_ERROR', 'error_msg'=>'商品庫存不足', 'detail'=>null);

			//轉帳給公司買商品
			$price = $product->price*$quantity;
			$description = '購買商品：'.$product->name.'(消費金額：'.$product->price.'*'.$quantity.'='.$price.')';
			$transfer_result = $this->accountService->transfer($member_id,null,1,$price,0,7,$description);
			if($transfer_result['result']==0)
				return $transfer_result;

			//加入背包
			if($addin_bag==1)
				$this->add_product_to_member($product_id, $member_id, $quantity);

			//購買紀錄
			$t = $this->transaction_record(null, $member_id, $product_id, $product->price, $quantity, 0, 'buy', $description);
			
		}catch(Exception $e){
			return array('result'=>0, 'error_code'=>'DB_ERROR', 'error_msg'=>'DB transaction失敗', 'detail'=>$e->getMessage());
		}
		
		return array('result'=>1, 'success_msg'=>'購買商品成功', 'transaction_id'=>$t->id);		
	}


	//贈送商品
	public function send($product_id, $member_id, $quantity, $admin, $description)
	{
		//查看商品是否存在
		try{
			$product = Product::findOrFail($product_id);
		}catch(Exception $e){
			return array('result'=>0, 'error_code'=>'PRODUCT_NOT_FIND', 'error_msg'=>'找不到此商品', 'detail'=>$e->getMessage());
		}

		try{
			//加入背包
			$this->add_product_to_member($product_id, $member_id, $quantity);

			//購買紀錄
			//$description = '管理員：'.$admin->name.'(ID:'.$admin->id.')贈送';
			$transaction = $this->transaction_record(null, $member_id, $product_id, 0, $quantity, 0, 'give', $description);
			
		}catch(Exception $e){
			return array('result'=>0, 'error_code'=>'DB_ERROR', 'error_msg'=>'DB transaction失敗', 'detail'=>$e->getMessage());
		}
		
		return array('result'=>1, 'success_msg'=>'贈送商品成功', 'transaction_id'=>$transaction->id);		
	}



	//購買紀錄
	public function transaction_record($transfer, $receive, $product_id, $price, $quantity, $fee, $type, $description)
	{
		$t = Transaction::create([
			'transfer_member_id' => $transfer,
			'receive_member_id' => $receive,
			'product_id' => $product_id,
			'price' => $price,
			'quantity' => $quantity,
			'fee' => $fee,
			'total' => $price*$quantity+$fee,
			'type' => $type,
			'description' => $description,
		]);
		return $t;
	}


	//庫存減少判斷
	public function subtract_minus($product_model, $number)
	{
		if($product_model->subtract==1){
			if($number > $product_model->quantity){
				return 0;
			}else{
				$product_model->update([
					'quantity' => ($product_model->quantity - $number),
				]);
			}
		}
		return 1;
	}


	//將商品放入member背包
	public function add_product_to_member($product_id, $member_id, $quantity)
	{
		//確認背包是某有該物品
		try{
			$bag = ProductBag::where('member_id',$member_id)->where('product_id',$product_id)->lockForUpdate()->firstOrFail();
			$new_quantity = $bag->quantity + $quantity;
			$bag->update([
				'quantity' => $new_quantity,
			]);
		}catch(Exception $e){
			if ($e instanceof ModelNotFoundException) {
				$bag = ProductBag::create([
					'member_id' => $member_id,
					'product_id' => $product_id,
					'quantity' => $quantity,
				]);
			}else{
				return array('result'=>0, 'error_code'=>'DB_ERROR', 'error_msg'=>'更新背包失敗', 'detail'=>$e->getMessage());
			}
		}
	
		return array('result'=>1, 'bag'=>$bag);
	}
}