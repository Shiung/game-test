<?php

namespace App\Http\Controllers\Admin\Member;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Services\Member\SubsDeleteRecordService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;

class SubsDeleteRecordsController extends Controller
{
    /**
     * 參數設定
     *
     * @var string
     */
    protected $recordService;
    protected $userService;
    protected $page_title = '好友帳戶刪除申請列表';
    protected $menu_title = '好友帳戶刪除申請列表';
    protected $route_code = 'subs_delete_record';
    protected $view_data = [];


    /**
     * 開頭宣告
     *
     * @return void
     */
    public function __construct(SubsDeleteRecordService $recordService, UserService $userService)
    {
        $this->recordService = $recordService;
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
     * @return view admin/shop/charge/index.blade.php
     */
    public function index($start = null, $end = null)
    {
        if(!$start || !$end){
            $date_info = getDefaultDateRange(7);
            $start = $date_info['start'];
            $end = $date_info['end'];
        }
    	$datas = $this->recordService->all($start,$end); 
        $data =[
            'datas' => $datas,
            'start' => $start,
            'end' => $end,
        ];
        return view('admin.member.'.$this->route_code.'.index',array_merge($this->view_data,$data));
    }


    /**
     * 資料更新處理
     *
     * @param  $id
     * @param Request $request
     * @return json
     */
    public function update($id,Request $request)
    {   
        $item = $this->recordService->find($id);
        if(!$item){
            return json_encode(array('result' => 0, 'text' => '資料不存在'));
        }
        if($item->status == 1) {
            return json_encode(array('result' => 0, 'text' => '申請已確認，請勿重複處理'));
        }


        if($request->action == 'confirm'){
            $user = $item->delete_user;
            $member = $user->member;

            //檢查下線
            if(!$this->recordService->checkTree($member)){
                return json_encode(array('result' => 0, 'text' => '該會員有下線'));
            }

            //檢查帳戶餘額
            if(!$this->recordService->checkAccount($member)){
                return json_encode(array('result' => 0, 'text' => '該會員帳戶餘額不符合資格'));
            }


            //檢查登入時間
            if(!$this->recordService->checkLastActivity($user)){
                return json_encode(array('result' => 0, 'text' => '該會員登入時間不符合資格'));
            }

            $result = $this->recordService->confirm($id);
        } else {
            $result = $this->recordService->reject($id);
        }

        if ($result['status']) {
            return json_encode(array('result' => 1, 'text' => 'Success'));
        } else {
            return json_encode(array('result' => 0, 'text' => 'Failed：'.$result['error_code'],'content' => $result['error_msg']));
        }
    }



}
