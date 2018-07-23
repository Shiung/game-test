<?php

namespace App\Http\Controllers\Admin\Shop\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Services\Shop\CategoryService;
use App\Services\Shop\Product\AuctionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;

class AuctionsController extends Controller
{
    /**
     * 參數設定
     *
     * @var string
     */
    protected $auctionService;
    protected $category;
    protected $page_title = '拍賣卡';
    protected $menu_title = '商品管理';
    protected $route_code = 'auction';
    protected $view_data = [];


    /**
     * 開頭宣告
     *
     * @return void
     */
    public function __construct(CategoryService $categoryService,AuctionService $auctionService)
    {
        $this->auctionService = $auctionService;
        $this->categoryService = $categoryService;
        $this->category = $this->categoryService->find(6);
        $this->view_data = [
            'route_code' => $this->route_code,
            'page_title' => $this->page_title,
            'menu_title' => $this->menu_title,
        ];
    }
    
    /**
     * 所有資料頁面
     *
     * @return view front/shop/product/auction/index.blade.php
     */
    public function index()
    {
    	$datas = $this->auctionService->all($this->category->id,'%'); 
        $data =[
            'datas' => $datas,
        ];
        return view('admin.shop.product.'.$this->route_code.'.index',array_merge($this->view_data,$data));
    }

    /**
     * 新增畫面
     *
     * @return view front/shop/product/auction/create.blade.php
     */
    public function create()
    {   
        $data =[];
        return view('admin.shop.product.'.$this->route_code.'.create',array_merge($this->view_data,$data));
    }

    /**
     * 資料新增處理
     *
     * @param  Request $request
     * @return json
     */
    public function store(Request $request)
    {   
        $data = [
            'category' => $this->category->id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'subtract' => $request->subtract,
            'icon' => 'front/img/icon/card/card_sale_01.png'
        ];
        $result = $this->auctionService->add($data,'/product/create_product_auction');
        if ($result['status']) {
            return json_encode(array('result' => 1, 'text' => 'Success'));
        } else {
            return json_encode(array('result' => 0, 'text' => $result['error_code'].$result['error_msg'],'content' => $result['error_msg'],'comment' => $data));
        }
    }

    /**
     * 資訊頁面
     *
     * @param  int $id
     * @return view front/shop/product/auction/show.blade.php
     */
    public function show($id)
    {   
        $item = $this->auctionService->find($id);
        if(!$item){
            return json_encode(array('result' => 0, 'text' => '資料不存在'));
        }
        if($item->product_category_id != $this->category->id){
            return json_encode(array('result' => 0, 'text' => '資料不存在'));
        }
        $data =[
            'data' => $item
        ];
        return view('admin.shop.product.'.$this->route_code.'.show',array_merge($this->view_data,$data));
    }

    /**
     * 資訊編輯頁面
     *
     * @param  int $id
     * @return view front/shop/product/auction/edit.blade.php
     */
    public function edit($id)
    {   
        $item = $this->auctionService->find($id);
        $data =[
            'data' => $item
        ];
        return view('admin.shop.product.'.$this->route_code.'.edit',array_merge($this->view_data,$data));
    }

    /**
     * 資料更新處理
     *
     * @param  int $id, 
     * @param Request $request
     * @return json
     */
    public function update($id,Request $request)
    {   
        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'quantity' => $request->quantity,
            'subtract' => $request->subtract,
        ];
        $result = $this->auctionService->update($id,$data);
        if ($result['status']) {
            return json_encode(array('result' => 1, 'text' => 'Success'));
        } else {
            return json_encode(array('result' => 0, 'text' => 'Failed：'.$result['error_code'].$result['error_msg'],'content' => $result['error_msg'],'comment' => $data));
        }
    }


    /**
     * 資料更新處理
     *
     * @param  int $id
     * @param Request $request
     * @return json
     */
    public function changeStatus($id,Request $request)
    {   
        $item = $this->auctionService->find($id);
        if(!$item){
            return json_encode(array('result' => 0, 'text' => '資料不存在'));
        }
        if($item->product_category_id != $this->category->id){
            return json_encode(array('result' => 0, 'text' => '資料不存在'));
        }

        $result = $this->auctionService->changeStatus($id,$request->status);
        if ($result['status']) {
            return json_encode(array('result' => 1, 'text' => 'Success'));
        } else {
            return json_encode(array('result' => 0, 'text' => 'Failed：'.$result['error_code'],'content' => $result['error_msg']));
        }
    }



}
