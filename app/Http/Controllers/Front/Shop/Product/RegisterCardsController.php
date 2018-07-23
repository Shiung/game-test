<?php

namespace App\Http\Controllers\Front\Shop\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Shop\Product\RegisterCardService;
use App\Services\UserService;
use App\Services\System\ParameterService;
use App;
use Auth;
use Validator;

class RegisterCardsController extends Controller
{

    protected $productService;
    protected $parameterService;
    protected $userervice;
    protected $user;
    protected $position_count;
    protected $route_code = 'register_card';
    protected $page_title = '邀請卡';

	public function __construct(
        RegisterCardService $productService,
        UserService $userService,
        ParameterService $parameterService
    ) {
        $this->productService = $productService;
        $this->userService = $userService;
        $this->parameterService = $parameterService;
        $this->user = Auth::guard('web')->user();
        $this->position_count = $this->parameterService->find('tree_parent');
    }

    /**
     * 使用推薦卡首頁
     * @param int $product_id
     * @return view front/shop/product/register_card/use_index.blade.php
     */
    public function useIndex($product_id = null)
    {
        $product = $this->productService->find($product_id);
        if(!$product_id){
            abort(404);
        }

    	$data=[
            'product' => $product,
            'info' => $product->info,
            'category' => $product->category,
            'route_code' => $this->route_code,
            'page_title' => $this->page_title,
            'position_count' => $this->position_count
    	];

	    return view('front.shop.product.'.$this->route_code.'.use_index',$data);
    }

    /**
     * 資料儲存處理
     *
     * @param  Request $request
     * @return json
     */
    public function useProcess(Request $request)
    {
        //檢查帳號是否可用
        $member = $this->userService->getUserByUsername($request->username);
        if($member){
            return json_encode(array('result' => 0, 'text' => '帳號已存在，請重新輸入'));
        }
        //檢查接點人帳號是否存在
        $parent = $this->userService->getUserByUsername($request->parent_username);
        if(!$parent){
            return json_encode(array('result' => 0, 'text' => '接點人帳號不存在'));
        }
        //接點人已被刪除
        if($parent->member->show_status == 0){
            return json_encode(array('result' => 0, 'text' => '接點人帳號不存在'));
        }
        $data = $request->all();
        $data['parent_id'] = $parent->id;

        $result = $this->productService->useProduct($request->product_id,1,$data);
        if ($result['status']) {
            return json_encode(array('result' => 1, 'text' => 'Success'));
        } else {
            return json_encode(array('result' => 0, 'text' => $result['error_msg']));
        }      
    }

    /**
     * 資訊頁面
     *
     * @param int $id 商品id
     * @param int $quantity_show 是否顯示庫存
     * @return view front/shop/product/register_card/show.blade.php
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


}
