<?php

namespace App\Http\Controllers\Front\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Shop\WithdrawalService;
use App;
use Auth;
use Validator;

class WithdrawalsController extends Controller
{

    protected $withdrawalService;
    protected $user;
    protected $page_title = '紅包群發紀錄';
    protected $route_code = 'withdrawal';
    
	public function __construct(
        WithdrawalService $withdrawalService
    ) {
        $this->withdrawalService = $withdrawalService;
        $this->user = Auth::guard('web')->user();
    }

    /**
     * 列表
     *
     * @return view front/shop/withdrawal/index.blade.php
     */
    public function index($start=null,$end=null)
    {
        if(!$start || !$end){
            $date_info = getDefaultDateRange(30);
            $start = $date_info['start'];
            $end = $date_info['end'];
        }
    	$data=[
            'datas' => $this->withdrawalService->allByMember($this->user->id,$start,$end),
            'start' => $start,
            'end' => $end,
            'route_code' => $this->route_code,
            'page_title' => $this->page_title
    	];

	    return view('front.shop.'.$this->route_code.'.index',$data);
    }

    
    

}
