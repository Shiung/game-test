<?php

namespace App\Http\Controllers\Front\Member;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\System\UserLoginService;
use App\Services\Member\MemberService;
use App\Services\UserService;
use App;
use Auth;
use Validator;

class LoginRecordsController extends Controller
{

    protected $recordService;
    protected $userService;
    protected $memberService;
    protected $user;
    protected $page_title = '登入紀錄';
    protected $route_code = 'login_record';
    
	public function __construct(
        UserLoginService $recordService,
        UserService $userService,
        MemberService $memberService
    ) {
        $this->recordService = $recordService;
        $this->userService = $userService;
        $this->memberService = $memberService;
        $this->user = Auth::guard('web')->user();     
        
    }

    /**
     * 搜尋頁面
     *
     * @return view front/member/login_record/search.blade.php
     */
    public function search()
    {
        $data=[
            'route_code' => $this->route_code,
            'page_title' => $this->page_title,
        ];
        return view('front.member.'.$this->route_code.'.search',$data); 
    }

    /**
     * 搜尋結果明細
     * @param Request $request
     * @return view front/member/login_record/index.blade.php
     */
    public function index(Request $request)
    {
        $search_result = 'Y';
        $datas = [];

        //時間區間
        $date_info = getPeriodDateRange($request->range);
        $start = $date_info['start'];
        $end = $date_info['end'];

        //處理會員
        if($request->user_type != 'sub'){
            $user = $this->user;
        } else {
            //檢查帳號是否存在
            $user = $this->userService->getUserByUsername($request->username);
            if(!$user){
                $search_result = 'N';
            } else {
                //檢查開帳號是否為本人下線
                $check_tree = $this->memberService->checkMemberInTree($this->user->id,$user->id);
                if($check_tree['status']){
                    if($check_tree['in_tree'] == 0){
                        $search_result = 'N';
                    }   
                } else {
                    $search_result = 'N';
                }
            }

        }

        if($user){
            //取得登入紀錄
            $datas = $this->recordService->allByMember($user->id,$start,$end);
        }

    	$data=[
            'datas' => $datas,
            'range' => $request->range,
            'user' => $user,
            'search_result' => $search_result,
            'route_code' => $this->route_code,
            'page_title' => $this->page_title,
    	];
        return view('front.member.'.$this->route_code.'.index',$data); 
    }

    
}
