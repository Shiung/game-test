<?php

namespace App\Http\Controllers\Front\Shop\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Shop\Product\AuctionService;
use App;
use Auth;
use Validator;
use Session;

class AuctionsController extends Controller
{

    protected $productService;
    protected $user;
    protected $member;
    protected $page_title = '拍賣卡';
    protected $route_code = 'auction';

	public function __construct(
        AuctionService $productService   
    ) {
        $this->productService = $productService;
        $this->user = Auth::guard('web')->user();
        $this->member = $this->user->member;
    }

    

    /**
     * 資料儲存處理
     *
     * @param  Request $request
     * @return json
     */
    public function useProcess(Request $request)
    {
        $result = $this->productService->useProduct($request->product_id,1,['share_price'=> $request->price,'share_quantity' => $request->transaction_quantity]);
        if ($result['status']) {
            return json_encode(array('result' => 1, 'text' => 'Success'));
        } else {
            return json_encode(array('result' => 0, 'error_code' => $result['error_code'], 'error_msg' => $result['error_msg']));
        } 
    }

    /**
     * 資訊頁面
     *
     * @param int $id 商品id
     * @param int $quantity_show 是否顯示庫存
     * @return view front/shop/product/auction/show.blade.php
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
