<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Services\Shop\ChargeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;

class ChargesController extends Controller
{
    /**
     * 參數設定
     *
     * @var string
     */
    protected $chargeService;
    protected $page_title = '線上儲值列表';
    protected $menu_title = '線上儲值列表';
    protected $route_code = 'charge';
    protected $view_data = [];


    /**
     * 開頭宣告
     *
     * @return void
     */
    public function __construct(ChargeService $chargeService)
    {
        $this->chargeService = $chargeService;
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
     * @return view admin/shop/charge/index.blade.php
     */
    public function index($start = null, $end = null)
    {
        if(!$start || !$end){
            $date_info = getDefaultDateRange(7);
            $start = $date_info['start'];
            $end = $date_info['end'];
        }
    	$datas = $this->chargeService->all($start,$end); 
        $data =[
            'datas' => $datas,
            'start' => $start,
            'end' => $end,
        ];
        return view('admin.shop.'.$this->route_code.'.index',array_merge($this->view_data,$data));
    }


    /**
     * 資料更新處理
     *
     * @param  $id
     * @param Request $request
     * @return json
     */
    public function update($id,Request $request)
    {   
        $item = $this->chargeService->find($id);
        if(!$item){
            return json_encode(array('result' => 0, 'text' => '資料不存在'));
        }
        if($item->confirm_status == 1) {
            return json_encode(array('result' => 0, 'text' => '金幣已發放，請勿重複發放'));
        }


        $result = $this->chargeService->confirm($id,$request->status);
        if ($result['status']) {
            return json_encode(array('result' => 1, 'text' => 'Success'));
        } else {
            return json_encode(array('result' => 0, 'text' => 'Failed：'.$result['error_code'],'content' => $result['error_msg']));
        }
    }



}
