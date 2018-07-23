<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Services\Shop\ProductUseRecordService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;

class ProductUseRecordsController extends Controller
{
    /**
     * 參數設定
     *
     * @var string
     */
    protected $recordService;
    protected $productService;
    protected $page_title = '商品使用紀錄';
    protected $menu_title = '商品使用紀錄';
    protected $route_code = 'product_use_record';
    protected $view_data = [];


    /**
     * 開頭宣告
     *
     * @return void
     */
    public function __construct(
        ProductUseRecordService $recordService
    ) {
        $this->recordService = $recordService;
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
     * @return view admin/shop/product_use_record/index.blade.php
     */
    public function index($start = null, $end = null)
    {
        if(!$start || !$end){
            $date_info = getDefaultDateRange(7);
            $start = $date_info['start'];
            $end = $date_info['end'];
        }
    	$datas = $this->recordService->all($start,$end); 
        $data =[
            'datas' => $datas,
            'start' => $start,
            'end' => $end,
        ];
        return view('admin.shop.'.$this->route_code.'.index',array_merge($this->view_data,$data));
    }


    


}
