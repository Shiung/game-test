<?php

namespace App\Http\Controllers\Front\Shop\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Shop\Product\AccountTransferService;
use App\Services\UserService;
use App\Services\Member\MobileSmsService;
use App;
use Auth;
use Validator;
use Session;

class AccountTransfersController extends Controller
{

    protected $productService;
    protected $userService;
    protected $smsService;
    protected $user;
    protected $page_title = '紅包卡';
    protected $route_code = 'account_transfer';

	public function __construct(
        AccountTransferService $productService,
        UserService $userService,
        MobileSmsService $smsService
    ) {
        $this->productService = $productService;
        $this->userService = $userService;
        $this->user = Auth::guard('web')->user();
        $this->smsService = $smsService;
    }

    /**
     * 使用紅包卡首頁
     * @param int $product_id
     * @return view front/shop/product/account_transfer/use_index.blade.php
     */
    public function useIndex($product_id = null)
    {
        $product = $this->productService->find($product_id);
        if(!$product_id){
            abort(404);
        }
    	$data=[
            'product' => $product,
            'cash_account' => $this->user->member->accounts->where('type','1')->first()->amount,
            'category' => $product->category,
            'route_code' => $this->route_code,
            'page_title' => $this->page_title
    	];

	    return view('front.shop.product.'.$this->route_code.'.use_index',$data);
    }

    /**
     * 輸入簡訊驗證碼頁面
     * @param Request $request
     * @return view front/shop/product/account_transfer/sms.blade.php
     */
    public function smsIndex(Request $request)
    {
        $sms_state = 1;
        $error = '';
        $message = '';
        //檢查參數
        $v = Validator::make($request->all(), [
            'type' => 'required|in:member,company',
            'amount' => 'required|min:0',
            'description' => 'required',
            'product_id' => 'required',
        ]);

        if ($v->fails()){
            return json_encode(array('result' => 0,'error' => 'REQUEST_ERROR', 'text' => '參數不正確','content' => $v->messages()));
        }

        /*if($request->type == 'member'){
            $receive = $this->userService->getUserByUsername($request->receive);
            if(!$receive){
                $sms_state = 0;
                $error = '會員帳號不存在';
            }
            $receive_user_id = $receive->id;
            $message = '您指定發紅包成功！';
        } else {
            $receive_user_id = 'company';
            $message = '您已送出不指定(群發)紅包申辦申請！';
        }*/

        $receive = $this->userService->getUserByUsername($request->receive);
        if(!$receive){
            $sms_state = 0;
            $error = '會員帳號不存在';
        }
        if($receive->member->show_status == 0){
            $sms_state = 0;
            $error = '會員帳號不存在';
        }
        $receive_user_id = $receive->id;
        $message = '您指定發紅包成功！';

        $data=[
            'sms_state' => $sms_state,
            'error' => $error,
            'receive' => $receive_user_id, 
            'amount' => $request->amount, 
            'description' => $request->description, 
            'product_id' => $request->product_id, 
            'message' => $message,
            'page_title' => '進行發紅包-簡訊驗證',
        ];
        return view('front.shop.product.'.$this->route_code.'.sms',$data);
        
    }


    /**
     * 簡訊認證+資料儲存處理
     *
     * @param  Request $request
     * @return json
     */
    public function useProcess(Request $request)
    {
        //檢查參數
        $v = Validator::make($request->all(), [
            'code' => 'required',
            'id' => 'required',
            'receive' => 'required',
            'amount' => 'required|min:0',
            'description' => 'required',
            'product_id' => 'required',
        ]);

        if ($v->fails()){
            return json_encode(array('result' => 0,'error' => 'REQUEST_ERROR', 'text' => '參數不正確','content' => $v->messages()));
        }

        //呼叫產生簡訊認證
        $result = $this->smsService->verify($request->id,$request->code);
        if($result['status']){
            $data= [
               'receive' => $request->receive, 
               'amount' => $request->amount, 
               'description' => $request->description, 
            ];
            $result = $this->productService->useProduct($request->product_id,1,$data);
            if ($result['status']) {
                return json_encode(array('result' => 1, 'text' => 'Success'));
            } else {
                return json_encode(array('result' => 0, 'text' => $result['error_msg'],'id' => $request->id));
            }  
        } else {
            return json_encode(array('result' => 0,'error' => $result['error_msg'], 'text' => $result['error_msg'],'id' => $result['id']));
        }

    }

    /**
     * 資訊頁面
     *
     * @param int $id 商品id
     * @param int $quantity_show 是否顯示庫存
     * @return view front/shop/product/account_transfer/show.blade.php
     */
    public function show($id,$quantity_show=1)
    {   
        $item = $this->productService->find($id);
        if(!$item){
            return json_encode(array('result' => 0, 'text' => '資料不存在'));
        }
        $data =[
            'data' => $item,
            'quantity_show' => $quantity_show
        ];
        return view('front.shop.product.'.$this->route_code.'.show',$data);
    }

    /**
     * 檢查會員帳號是否可用
     *
     * @param  Request $request
     * @return json
     */
    public function checkUsernameValid(Request $request)
    {
        $receive = $this->userService->getUserByUsername($request->receive);
        if(!$receive){
            return json_encode(array('result' => 0, 'text' => '會員帳號不存在'));
        } else {
            if($receive->member->show_status == 0){
                return json_encode(array('result' => 0, 'text' => '會員帳號不存在'));
            }
            if($receive->id == $this->user->id){
                return json_encode(array('result' => 0, 'text' => '請勿輸入本人帳號'));
            }     
        }
        return json_encode(array('result' => 1, 'text' => 'Success'));
    }

    

}
