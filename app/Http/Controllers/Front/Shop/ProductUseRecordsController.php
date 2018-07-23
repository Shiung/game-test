<?php

namespace App\Http\Controllers\Front\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Shop\ProductUseRecordService;
use App;
use Auth;
use Validator;

class ProductUseRecordsController extends Controller
{

    protected $recordService;
    protected $user;
    protected $page_title = '商品使用記錄';
    protected $route_code = 'product_use_record';
    
	public function __construct(
        ProductUseRecordService $recordService
    ) {
        $this->recordService = $recordService;
        $this->user = Auth::guard('web')->user();
    }

    /**
     * 列表
     * @param date $start
     * @param date $end
     * @return view front/shop/product_use_record/index.blade.php
     */
    public function index($start=null,$end=null)
    {
        if(!$start || !$end){
            $date_info = getDefaultDateRange(3);
            $start = $date_info['start'];
            $end = $date_info['end'];
        }
    	$data=[
            'datas' => $this->recordService->allByMember($this->user->id,$start,$end),
            'start' => $start,
            'end' => $end,
            'route_code' => $this->route_code,
            'page_title' => $this->page_title
    	];

	    return view('front.shop.'.$this->route_code.'.index',$data);
    }

   

}
