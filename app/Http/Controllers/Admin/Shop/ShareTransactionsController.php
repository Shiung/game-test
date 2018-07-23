<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Services\Shop\ShareTransactionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;

class ShareTransactionsController extends Controller
{
    /**
     * 參數設定
     *
     * @var string
     */
    protected $transactionService;
    protected $page_title = '娛樂幣掛單紀錄';
    protected $menu_title = '娛樂幣掛單紀錄';
    protected $route_code = 'share_transaction';
    protected $view_data = [];


    /**
     * 開頭宣告
     *
     * @return void
     */
    public function __construct(ShareTransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
        $this->view_data = [
            'route_code' => $this->route_code,
            'page_title' => $this->page_title,
            'menu_title' => $this->menu_title,
        ];

    }
    
    /**
     * 所有資料頁面
     * @param int $status
     * @param date $start
     * @param date $end
     * @return view admin/shop/share_transaction/index.blade.php
     */
    public function index($status='N' ,$start = null, $end = null)
    {
        if(!$start || !$end || $status == 'N'){
            $date_info = getDefaultDateRange(7);
            $start = $date_info['start'];
            $end = $date_info['end'];
            $status = 0;
            $datas = $this->transactionService->allByStatus($status,$start,$end); 
        } else {
            $datas = $this->transactionService->allByStatus($status,$start,$end); 
        }
        $data =[
            'datas' => $datas,
            'start' => $start,
            'status' => $status,
            'end' => $end,
        ];
        return view('admin.shop.'.$this->route_code.'.index',array_merge($this->view_data,$data));
    }




}
