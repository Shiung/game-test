<?php

namespace App\Http\Controllers\Front\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Shop\ChargeService;
use App\Services\Member\SmsService;
use App;
use Auth;
use Validator;

class ChargesController extends Controller
{

    protected $chargeService;
    protected $smsService;
    protected $user;
    protected $page_title = '線上儲值';
    protected $route_code = 'charge';
    
	public function __construct(
        ChargeService $chargeService,
        SmsService $smsService
    ) {
        $this->chargeService = $chargeService;
        $this->smsService = $smsService;
        $this->user = Auth::guard('web')->user();
    }

    /**
     * 列表
     * @param date $start
     * @param date $end
     * @return view front/shop/charge/index.blade.php
     */
    public function index($start=null,$end=null)
    {
        if(!$start || !$end){
            $date_info = getDefaultDateRange(30);
            $start = $date_info['start'];
            $end = $date_info['end'];
        }
    	$data=[
            'datas' => $this->chargeService->allByMember($this->user->id,$start,$end),
            'start' => $start,
            'end' => $end,
            'route_code' => $this->route_code,
            'page_title' => $this->page_title
    	];

	    return view('front.shop.'.$this->route_code.'.index',$data);
    }

    /**
     * 資料儲存處理
     *
     * @param  Request $request
     * @return json
     */
    public function store(Request $request)
    {
        $data= [
           'member_id' => $this->user->id, 
           'amount' => $request->amount, 
        ];
        $result = $this->chargeService->add($data);

        if ($result['status']) {
            //寄出簡訊
            $msg = '收到會員:'.$this->user->member->member_number.' 儲值記錄，還請儘速處理';

            $this->smsService->send(env('NOTIFICATION_PHONE','0908373758'),$msg);
            return json_encode(array('result' => 1, 'text' => $msg));
        } else {
            return json_encode(array('result' => 0, 'text' => $result['error']));
        }      
    }


    /**
     * 刪除處理
     *
     * @param  $id
     * @return json
     */
    public function destroy($id)
    {
        $item = $this->chargeService->find($id);
        if(!$item){
            return json_encode(array('result' => 0, 'text' => '資料不存在'));
        }

        if($item->member_id != $this->user->id){
            return json_encode(array('result' => 0, 'text' => '您沒有權限操作'));
        }

        if($item->pay_status == 1) {
            return json_encode(array('result' => 0, 'text' => '此筆紀錄已紀錄付款'));
        }

        if($item->confirm_status == 1) {
            return json_encode(array('result' => 0, 'text' => '金幣已發放'));
        }

        $result = $this->chargeService->delete($id);
        if ($result['status']) {
            return json_encode(array('result' => 1, 'text' => 'Success'));
        } else {
            return json_encode(array('result' => 0, 'text' => $result['error']));
        }      
    }

}
