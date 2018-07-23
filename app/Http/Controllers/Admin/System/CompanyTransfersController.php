<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Services\UserService;
use App\Services\System\CompanyTransferService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;

class CompanyTransfersController extends Controller
{
    /**
     * 參數設定
     *
     * @var string
     */
    protected $transferService;
    protected $userService;
    protected $page_title = '公司發紅包';
    protected $menu_title = '公司發紅包';
    protected $route_code = 'company_transfer';
    protected $view_data = [];


    /**
     * 開頭宣告
     *
     * @return void
     */
    public function __construct(CompanyTransferService $transferService, UserService $userService)
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
     * @return view admin/system/company_transfer/index.blade.php
     */
    public function index($start = null, $end = null)
    {
        if(!$start || !$end){
            $date_info = getDefaultDateRange(30);
            $start = $date_info['start'];
            $end = $date_info['end'];
        }
    	$datas = $this->transferService->all([6],$start,$end); 
        $data =[
            'datas' => $datas,
            'start' => $start,
            'end' => $end,
        ];
        return view('admin.system.'.$this->route_code.'.index',array_merge($this->view_data,$data));
    }

    
    /**
     * 新增畫面
     *
     * @return view admin/system/company_transfer/create.blade.php
     */
    public function create()
    {
        $data=[
        ];
        return view('admin.system.'.$this->route_code.'.create',array_merge($this->view_data,$data));
    }

    /**
     * 資料儲存處理（會員轉帳）
     *
     * @param  Request $request
     * @return json
     */
    public function storeMemberTransfer(Request $request)
    {
        $transfer_user = $this->userService->getUserByUsername($request->transfer);
        if(!$transfer_user){
            return json_encode(array('result' => 0, 'text' => '轉出會員不存在，請重新輸入'));
        }
        $receive_user = $this->userService->getUserByUsername($request->receive);
        if(!$receive_user){
            return json_encode(array('result' => 0, 'text' => '轉入會員不存在，請重新輸入'));
        }
        $data= [
           'transfer' => $transfer_user->id, 
           'money' => $request->money, 
           'receive' => $receive_user->id, 
        ];
        if($request->transfer )
        $result = $this->transferService->add($data);
        if ($result['status']) {
            return json_encode(array('result' => 1, 'text' => 'Success'));
        } else {
            return json_encode(array('result' => 0, 'text' => 'Failed：'.$result['error_msg']));
        }      
    }

    /**
     * 資料儲存處理(公司轉帳)
     *
     * @param  Request $request
     * @return json
     */
    public function storeCompanyTransfer(Request $request)
    {

        $user = $this->userService->getUserByUsername($request->username);
        if(!$user){
            return json_encode(array('result' => 0, 'text' => '會員不存在，請重新輸入'));
        }
        if($request->money < 0){
            $transfer = $user->id;
            $receive= 'company';
        } else {
            $transfer = 'company';
            $receive = $user->id;
        }
        $data= [
           'transfer' => $transfer, 
           'money' => abs($request->money), 
           'receive' => $receive, 
        ];
        
        $result = $this->transferService->add($data);
        if ($result['status']) {
            return json_encode(array('result' => 1, 'text' => 'Success'));
        } else {
            return json_encode(array('result' => 0, 'text' => 'Failed：'.$result['error_msg']));
        }      
    }

    


}
