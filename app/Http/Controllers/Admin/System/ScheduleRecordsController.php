<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Services\System\ScheduleRecordService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;

class ScheduleRecordsController extends Controller
{
    /**
     * 參數設定
     *
     * @var string
     */
    protected $recordService;
    protected $page_title = '排程記錄';
    protected $menu_title = '排程記錄';
    protected $route_code = 'schedule_record';
    protected $view_data = [];


    /**
     * 開頭宣告
     *
     * @return void
     */
    public function __construct(ScheduleRecordService $recordService)
    {
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
     * @return view admin/system/schedule_record/index.blade.php
     */
    public function index($start = null, $end = null, $name = '%')
    {
        if(!$start || !$end){
            $date_info = getDefaultDateRange(1);
            $start = $date_info['start'];
            $end = $date_info['end'];
        }
    	$datas = $this->recordService->all($start,$end,$name); 
        $data =[
            'datas' => $datas,
            'name_datas' => $this->recordService->getNames($start,$end),
            'record_name' => $name,
            'start' => $start,
            'end' => $end,
        ];
        return view('admin.system.'.$this->route_code.'.index',array_merge($this->view_data,$data));
    }




}
