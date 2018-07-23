<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Services\UserService;
use App\Services\Account\TransferRecordService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;

class TransferRecordsController extends Controller
{
    /**
     * 參數設定
     *
     * @var string
     */
    protected $transferService;
    protected $userService;
    protected $page_title = '轉帳紀錄';
    protected $menu_title = '轉帳紀錄';
    protected $route_code = 'transfer_record';
    protected $view_data = [];


    /**
     * 開頭宣告
     *
     * @return void
     */
    public function __construct(TransferRecordService $transferService, UserService $userService)
    {
        $this->transferService = $transferService;
        $this->userService = $userService;
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
     * @return view admin/system/transfer_record/index.blade.php
     */
    public function index($start = null, $end = null)
    {
        if(!$start || !$end){
            $date_info = getDefaultDateRange(30);
            $start = $date_info['start'];
            $end = $date_info['end'];
        }
    	$datas = $this->transferService->all([2,6,8],$start,$end); 
        $data =[
            'datas' => $datas,
            'start' => $start,
            'end' => $end,
        ];
        return view('admin.system.'.$this->route_code.'.index',array_merge($this->view_data,$data));
    }

    
    


}
