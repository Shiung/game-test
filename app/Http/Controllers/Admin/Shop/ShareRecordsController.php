<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Services\Shop\Product\ShareService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;

class ShareRecordsController extends Controller
{
    /**
     * 參數設定
     *
     * @var string
     */
    protected $shareService;
    protected $page_title = '娛樂幣發行';
    protected $menu_title = '娛樂幣發行';
    protected $route_code = 'share_record';
    protected $view_data = [];


    /**
     * 開頭宣告
     *
     * @return void
     */
    public function __construct(ShareService $shareService)
    {
        $this->shareService = $shareService;
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
     * @return view admin/share_record/index.blade.php
     */
    public function index($start = null , $end= null)
    {
        if(!$start || !$end){
            $date_info = getDefaultDateRange(7);
            $start = $date_info['start'];
            $end = $date_info['end'];
        }
    	$datas = $this->shareService->getShareRecords($start,$end); 
        $data =[
            'datas' => $datas,
            'start' => $start,
            'end' => $end,
            'share' => $this->shareService->getNowShare(),
        ];
        return view('admin.'.$this->route_code.'.index',array_merge($this->view_data,$data));
    }


    /**
     * 發行/收回
     *
     * @param  Request $request
     * @return json
     */
    public function addRecord(Request $request)
    {       
        if($request->amount == 0){
            return json_encode(array('result' => 0, 'text' => '數字有誤，請勿輸入0'));
        }
        if($request->type == 'subtract'){
            $amount = 0-$request->amount;
        } else {
            $amount = $request->amount;
        }
        $result = $this->shareService->addShare($amount);
        if ($result['status']) {
            return json_encode(array('result' => 1, 'text' => 'Success'));
        } else {
            return json_encode(array('result' => 0, 'text' => $result['error_msg']));
        }
    }



}
