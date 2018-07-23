<?php

namespace App\Http\Controllers\Front\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Services\Shop\TransactionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;
use Auth;

class TransactionsController extends Controller
{
    /**
     * 參數設定
     *
     * @var string
     */
    protected $transactionService;
    protected $page_title = '商品取得紀錄';
    protected $route_code = 'transaction';
    protected $user;

    /**
     * 開頭宣告
     *
     * @return void
     */
    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
        $this->user = Auth::guard('web')->user();
    }
    
    /**
     * 所有資料頁面
     * @param date $start
     * @param date $end
     * @return view front/shop/transaction/index.blade.php
     */
    public function index($start = null, $end = null)
    {
        if(!$start || !$end){
            $date_info = getDefaultDateRange(30);
            $start = $date_info['start'];
            $end = $date_info['end'];
        }
    	$datas = $this->transactionService->allByReceiveMember($this->user->id,$start,$end); 
        $data =[
            'datas' => $datas,
            'start' => $start,
            'end' => $end,
            'route_code' => $this->route_code,
            'page_title' => $this->page_title
        ];
        return view('front.shop.'.$this->route_code.'.index',$data);
    }




}
