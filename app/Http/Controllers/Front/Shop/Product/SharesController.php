<?php

namespace App\Http\Controllers\Front\Shop\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Shop\Product\ShareService;
use App\Services\UserService;
use App;
use Auth;
use Validator;
use Session;

class SharesController extends Controller
{

    protected $productService;
    protected $userService;
    protected $user;
    protected $member;
    protected $page_title = '娛樂幣';
    protected $route_code = 'share';

	public function __construct(
        ShareService $productService,
        UserService $userService
    ) {
        $this->productService = $productService;
        $this->userService = $userService;
        $this->user = Auth::guard('web')->user();
         $this->member = $this->user->member;
    }

    /**
     * 使用權利碼首頁
     *
     * @param int $product_id
     * @return view front/shop/product/share/use_index.blade.php
     */
    public function useIndex($product_id = null)
    {
        $product = $this->productService->find($product_id);
        if(!$product_id){
            abort(404);
        }
        $accounts = $this->member->accounts;
        $product_bags = $this->member->my_products;
    	$data=[
            'product' => $product,
            'bag' => $product_bags->where('product_id',$product->id)->first(),
            'share_amount' => $accounts->where('type','3')->first()->amount,
            'category' => $product->category,
            'route_code' => $this->route_code,
            'page_title' => $this->page_title
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
        $result = $this->productService->useProduct($request->product_id,$request->quantity,[]);
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
     * @return view front/shop/product/share/show.blade.php
     */
    public function show($id,$quantity_show=1)
    {   
        $item = $this->productService->find($id);
        if(!$item){
            return json_encode(array('result' => 0, 'text' => '資料不存在'));
        }
        $data =[
            'share' => $this->productService->getNowShare(),
            'data' => $item,
            'quantity_show' => $quantity_show
        ];
        return view('front.shop.product.'.$this->route_code.'.show',$data);
    }
 

}
