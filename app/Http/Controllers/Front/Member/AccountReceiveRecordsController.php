<?php

namespace App\Http\Controllers\Front\Member;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Account\ReceiveRecordService;
use App;
use Auth;
use Validator;

class AccountReceiveRecordsController extends Controller
{

    protected $recordService;
    protected $member;
    protected $page_title = '簽到中心';
    protected $route_code = 'account_receive_record';
    protected $accounts;
    
	public function __construct(
        ReceiveRecordService $recordService
    ) {
        $this->recordService = $recordService;
        $this->member = Auth::guard('web')->user()->member;
        
        //可用餘額
        $accounts = $this->member->accounts;
        $this->accounts = [
            'cash' => $accounts->where('type','1')->first()->amount,
            'run' => $accounts->where('type','2')->first()->amount,
            'interest' => $accounts->where('type','4')->first()->amount,
            'right' => $accounts->where('type','3')->first()->amount
        ];
    }

    /**
     * 列表
     *
     * @return view front/account_receive_record/index.blade.php
     */
    public function index()
    {
        $date_info = getDefaultDateRange(365);
        $start = $date_info['start'];
        $end = $date_info['end'];
        $records = $this->recordService->allByMemberToPaginate($this->member->user_id,'0',$start,$end,'20');
    	$data=[
            'datas' => $records,
            'route_code' => $this->route_code,
            'page_title' => $this->page_title,
            'account_amount' => $this->accounts,
    	];
        return view('front.'.$this->route_code.'.index',$data); 
    }

    /**
     * 領取
     *
     * @param  Request $request
     * @return json
     */
    public function receive(Request $request)
    {
        $record = $this->recordService->find($request->id);
        if(!$record){
            return json_encode(array('result' => 0, 'text' => '紀錄不存在'));
        }
        if($record->status != 0){
            return json_encode(array('result' => 0, 'text' => '紀錄已過期or已領取'));
        }
        if($record->member_id != Auth::guard('web')->user()->id){
            return json_encode(array('result' => 0, 'text' => '此紀錄id非使用者可領取'));
        }

        $result = $this->recordService->receive($request->id);
        if ($result['status']) {
            return json_encode(array('result' => 1, 'text' => 'Success'));
        } else {
            return json_encode(array('result' => 0, 'text' => $result['error_msg']));
        }      
    }


    
}
