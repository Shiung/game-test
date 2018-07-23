<?php

namespace App\Http\Controllers\Front\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Shop\ChargeService;
use App;
use Auth;
use Validator;

class ProductBagsController extends Controller
{

    protected $chargeService;
    protected $member;
    protected $page_title = '我的商品';
    protected $route_code = 'my_product';
    protected $accounts;
    
	public function __construct(
        ChargeService $chargeService
    ) {
        $this->chargeService = $chargeService;
        $this->member = Auth::guard('web')->user()->member;
        
        //可用餘額
        $accounts = $this->member->accounts;
        $this->accounts = [
            'cash' => $accounts->where('type','1')->first()->amount,
            'run' => $accounts->where('type','2')->first()->amount,
            'interest' => $accounts->where('type','4')->first()->amount,
            'right' => $accounts->where('type','3')->first()->amount
        ];
    }

    /**
     * 列表
     *
     * @return view front/shop/my_product/index.blade.php
     */
    public function index()
    {
    	$data=[
            'datas' => $this->member->product_bags,
            'route_code' => $this->route_code,
            'page_title' => $this->page_title,
            'account_amount' => $this->accounts,
    	];
        return view('front.shop.'.$this->route_code.'.index',$data); 
    }

    /**
     * 使用商品
     *
     * @param  int $id 商品id
     * @return json
     */
    public function useProduct($id)
    {
        $data= [
           'member_id' => $this->user->id, 
           'amount' => $request->amount, 
        ];
        $result = $this->chargeService->add($data);
        if ($result['status']) {
            return json_encode(array('result' => 1, 'text' => 'Success'));
        } else {
            return json_encode(array('result' => 0, 'text' => $result['error']));
        }      
    }


    
}
