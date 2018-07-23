<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Services\Shop\ProductService;
use App\Services\Shop\TransactionService;
use App\Services\Member\MemberService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;

class GiveProductsController extends Controller
{
    /**
     * 參數設定
     *
     * @var string
     */
    protected $transactionService;
    protected $memberService;
    protected $productService;
    protected $page_title = '贈送商品';
    protected $menu_title = '贈送商品';
    protected $route_code = 'give_product';
    protected $view_data = [];


    /**
     * 開頭宣告
     *
     * @return void
     */
    public function __construct(
        TransactionService $transactionService,
        MemberService $memberService,
        ProductService $productService
    ) {
        $this->transactionService = $transactionService;
        $this->memberService = $memberService;
        $this->productService = $productService;
        $this->view_data = [
            'route_code' => $this->route_code,
            'page_title' => $this->page_title,
            'menu_title' => $this->menu_title,
        ];
    }
    
    /**
     * 所有資料頁面
     * @param date $start
     * @param date $end
     * @return view front/shop/give_product/index.blade.php
     * @return index view
     */
    public function index($start = null, $end = null)
    {
        if(!$start || !$end){
            $date_info = getDefaultDateRange(7);
            $start = $date_info['start'];
            $end = $date_info['end'];
        }
    	$datas = $this->transactionService->all('give',$start,$end); 
        $data =[
            'datas' => $datas,
            'start' => $start,
            'end' => $end,
        ];
        return view('admin.shop.'.$this->route_code.'.index',array_merge($this->view_data,$data));
    }


    /**
     * 新增頁面
     * 
     * @return view admin/shop/give_product/create.blade.php
     */
    public function create()
    {   
        $data =[
            'members' => $this->memberService->all(),
            'products' => $this->productService->all('%','1'),
        ];
        return view('admin.shop.'.$this->route_code.'.create',array_merge($this->view_data,$data));
    }


    /**
     * 資料新增處理
     *
     * @param  Request $request
     * @return json
     */
    public function store(Request $request)
    {   
        //檢查有沒有會員id
        if(count($request->ids) == 0){
            return json_encode(array('result' => 0, 'text' => '請選擇贈送會員'));
        }
        $item = $this->productService->find($request->product_id);
        if(!$item){
            return json_encode(array('result' => 0, 'text' => '商品不存在'));
        }

        $data = [
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'description' => $request->description,
            'members' => json_encode(['ids' => $request->ids])
        ]; 
        $result = $this->transactionService->giveProduct($data);
        if ($result['status']) {
            return json_encode(array('result' => 1, 'text' => 'Success'));
        } else {
            return json_encode(array('result' => 0, 'text' => $result['error_msg'],'content' => $data));
        }
    }


}
