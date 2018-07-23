<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Services\Shop\TransactionService;
use App\Services\Shop\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;

class TransactionsController extends Controller
{
    /**
     * 參數設定
     *
     * @var string
     */
    protected $transactionService;
    protected $categoryService;
    protected $page_title = '商品交易紀錄';
    protected $menu_title = '商品交易紀錄';
    protected $route_code = 'transaction';
    protected $view_data = [];


    /**
     * 開頭宣告
     *
     * @return void
     */
    public function __construct(TransactionService $transactionService, CategoryService $categoryService)
    {
        $this->transactionService = $transactionService;
        $this->categoryService = $categoryService;
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
     * @return view admin/shop/transaction/index.blade.php
     */
    public function index($category_id='%',$start = null, $end = null)
    {
        if(!$start || !$end){
            $date_info = getDefaultDateRange(7);
            $start = $date_info['start'];
            $end = $date_info['end'];
        }
        if($category_id == 'all'){
            $category_id = '%';
        }
    	$datas = $this->transactionService->allByCategoryId('%',$category_id,$start,$end); 
        $data =[
            'categories' => $this->categoryService->all(),
            'datas' => $datas,
            'start' => $start,
            'end' => $end,
            'category_id'=> $category_id
        ];
        return view('admin.shop.'.$this->route_code.'.index',array_merge($this->view_data,$data));
    }




}
