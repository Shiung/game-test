<?php

namespace App\Http\Controllers\Front\Shop\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Shop\Product\MemberCardService;
use App;
use Auth;
use Validator;

class MemberCardsController extends Controller
{

    protected $productService;
    protected $user;
    protected $route_code = 'member_card';
    protected $page_title = 'VIP卡';

	public function __construct(
        MemberCardService $productService
    ) {
        $this->productService = $productService;
        $this->user = Auth::guard('web')->user();
    }

    /**
     * 使用會員卡頁面
     * @param int $product_id
     * @return view front/shop/product/member_card/use_index.blade.php
     */
    public function useIndex($product_id)
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
        $result = $this->productService->useProduct($request->product_id,1,[]);
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
     * @return view front/shop/product/member_card/show.blade.php
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
