<?php

namespace App\Http\Controllers\Front\Member;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Member\BetRecordService;
use App\Services\UserService;
use App\Services\Member\MemberService;
use App\Services\System\ParameterService;
use App\Services\Game\CategoryService;
use App;
use Auth;
use Validator;

class BetRecordsController extends Controller
{

    protected $betRecordService;
    protected $userService;
    protected $memberService;
    protected $parameterService;
    protected $categoryService;
    protected $user;
    protected $page_title = '個人遊戲歷程';
    protected $route_code = 'bet_record';
    
	public function __construct(
        BetRecordService $betRecordService,
        UserService $userService,
        MemberService $memberService,
        ParameterService $parameterService,
        CategoryService $categoryService
    ) {
        $this->betRecordService = $betRecordService;
        $this->userService = $userService;
        $this->memberService = $memberService;
        $this->parameterService = $parameterService;
        $this->categoryService = $categoryService;
        $this->user = Auth::guard('web')->user();     
        
    }

    /**
     * 搜尋頁面
     *
     * @return view front/member/bet_record/search.blade.php
     */
    public function search()
    {
        $data=[
            'route_code' => $this->route_code,
            'page_title' => $this->page_title,
            'categories' => $this->categoryService->all()
        ];
        return view('front.member.'.$this->route_code.'.search',$data); 
    }

    /**
     * 搜尋結果明細
     * @param Request $request
     * @return view front/member/bet_record/index.blade.php
     */
    public function index(Request $request)
    {
        $search_result = 'Y';
        $datas = [];
        $record_total = [
            'amount' => 0 ,
            'result_amount' => 0,
            'real_bet_amount' => 0
        ];

        //時間區間
        $date_info = getPeriodDateRange($request->range,0);
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
                    if($check_tree['in_tree'] == 1 && $check_tree['level'] > $this->parameterService->find('search_parent_limit')){
                        $search_result = 'N';
                    }
                } else {
                    $search_result = 'N';
                }
            }
            

        }

        if($user){
            //取得紀錄
            $result = $this->betRecordService->allByMember('member',[
                'member_id' => $user->id,
                'bet_type' => $request->bet_type,
                'sport_type' => $request->sport_type,
                'account_type' => $request->account_type,
                'start_date' => $start,
                'end_date' => $end
            ]);

            $record_total = [
                'amount' => sumDataAmountByKey($result['datas'],'amount') ,
                'result_amount' => sumDataAmountByKey($result['datas'],'result_amount') ,
                'real_bet_amount' => sumDataAmountByKey($result['datas'],'real_bet_amount') 
            ];

            $datas = $result['datas'];
        }

        
        
        //處理參數資訊
        $type_data = $this->betRecordService->processBetRecordSearchParameters($request->all());
        $data = [
            'datas' => $datas,
            'account_type' => $type_data['account_type'],
            'bet_type' => $type_data['bet_type'],
            'sport_type' => $type_data['sport_type'],
            'range' => config('member.range.'.$request->range),
            'user' => $user,
            'search_result' => $search_result,
            'route_code' => $this->route_code,
            'page_title' => $this->page_title,
            'record_total' => $record_total,
    	];
        return view('front.member.'.$this->route_code.'.index',$data); 
    }

    
}
