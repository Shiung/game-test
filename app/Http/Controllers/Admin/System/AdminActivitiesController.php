<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Services\System\AdminActivityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;

class AdminActivitiesController extends Controller
{
    /**
     * 參數設定
     *
     * @var string
     */
    protected $adminActivityService;
    protected $page_title = '後台操作記錄';
    protected $menu_title = '後台操作記錄';
    protected $route_code = 'admin_activity';
    protected $view_data = [];


    /**
     * 開頭宣告
     *
     * @return void
     */
    public function __construct(AdminActivityService $adminActivityService)
    {
        $this->adminActivityService = $adminActivityService;
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
     * @return view admin/system/admin_activity/index.blade.php
     */
    public function index($start = null, $end = null)
    {
        if(!$start || !$end){
            $date_info = getDefaultDateRange(1);
            $start = $date_info['start'];
            $end = $date_info['end'];
        }
    	$datas = $this->adminActivityService->all($start,$end); 
        $data =[
            'datas' => $datas,
            'start' => $start,
            'end' => $end,
        ];
        return view('admin.system.'.$this->route_code.'.index',array_merge($this->view_data,$data));
    }




}
