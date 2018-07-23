<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Services\Shop\WithdrawalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;

class WithdrawalsController extends Controller
{
    /**
     * 參數設定
     *
     * @var string
     */
    protected $chargeService;
    protected $page_title = '紅包群發紀錄';
    protected $menu_title = '紅包群發紀錄';
    protected $route_code = 'withdrawal';
    protected $view_data = [];


    /**
     * 開頭宣告
     *
     * @return void
     */
    public function __construct(WithdrawalService $withdrawalService)
    {
        $this->withdrawalService = $withdrawalService;
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
     * @return view admin/shop/withdrawal/index.blade.php
     */
    public function index($start = null, $end = null)
    {
        if(!$start || !$end){
            $date_info = getDefaultDateRange(7);
            $start = $date_info['start'];
            $end = $date_info['end'];
        }
    	$datas = $this->withdrawalService->all($start,$end); 
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
     * @param  $id,Request $request
     * @return json
     */
    public function update($id,Request $request)
    {   
        $item = $this->withdrawalService->find($id);
        if(!$item){
            return json_encode(array('result' => 0, 'text' => '資料不存在'));
        }
        if($item->confirm_status != '0') {
            return json_encode(array('result' => 0, 'text' => '此紀錄已處理，請勿重複操作'));
        }


        $result = $this->withdrawalService->updateStatus($id,$request->status);
        if ($result['status']) {
            return json_encode(array('result' => 1, 'text' => 'Success'));
        } else {
            return json_encode(array('result' => 0, 'text' => $result['error_msg']));
        }
    }



}
