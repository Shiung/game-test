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
use Session;

class OrganizationBetRecordsController extends Controller
{

    protected $betRecordService;
    protected $userService;
    protected $memberService;
    protected $parameterService;
    protected $categoryService;
    protected $user;
    protected $page_title = '社群遊戲歷程';
    protected $route_code = 'organization_bet_record';
    
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
     * @return view front/member/organization_bet_record/search.blade.php
     */
    public function search()
    {
        //reset查詢參數
        if (Session::has('m_brecord_param')) {
            Session::forget('m_brecord_param');
        }

        $data=[
            'route_code' => $this->route_code,
            'page_title' => $this->page_title,
            'categories' => $this->categoryService->all()
        ];
        return view('front.member.'.$this->route_code.'.search',$data); 
    }

    /**
     * 搜尋結果總和資訊
     * @param Request $request
     * @return view front/member/organization_bet_record/index.blade.php
     */
    public function index(Request $request)
    {
        $search_result = 'Y';
        $datas = [];

        //限制最多找到第幾代
        $search_parent_limit = $this->parameterService->find('search_parent_limit'); 

        //紀錄查詢參數
        if($request->user_type != 'sub'){
            Session::put('m_brecord_param',[
                'range' => $request->range,
                'sport_type' => $request->sport_type,
                'bet_type' => $request->bet_type,
                'account_type' => $request->account_type
            ]);
        } 
        $parameters = Session::get('m_brecord_param');

        //時間區間
        $date_info = getPeriodDateRange($parameters['range'],0);
        $start = $date_info['start'];
        $end = $date_info['end'];

        //處理會員
        if($request->user_type != 'sub'){
            $user = $this->user;
            $level = 1;
        } else {
            $user = $this->userService->find($request->user_id);
            //檢查開帳號是否為本人下線
            $check_tree = $this->memberService->checkMemberInTree($this->user->id,$user->id);
            if($check_tree['status']){
                if($check_tree['in_tree'] == 0){
                    $search_result = 'N';
                }
                if($check_tree['in_tree'] == 1 && $check_tree['level'] > $search_parent_limit){
                    //超過四代，導向明細頁面
                    return redirect()->route('front.organization_bet_record.detail',$user->id);
                }
                $level = $check_tree['level']+1  ;
            } else {
                $search_result = 'N';
            }
            
        }

        //找樹下線
        $member = $user->member;
        $tree_sub_members = $member->tree_sub_members;
        if(count($tree_sub_members) == 0){
            //無下線，導向明細頁面
            return redirect()->route('front.organization_bet_record.detail',$user->id);
        }

        $parent_level = $search_parent_limit - $level;

        //取得下線、總和資料
        $sub_result = $this->betRecordService->getSubsBetTotal('member',$tree_sub_members,$parameters,$start,$end,$parent_level);
        $datas = $sub_result['datas'];
        $total_data = $sub_result['total_data'];
        
        //下線下注筆數都是零，導向明細頁面
        if($total_data['count'] == 0){
            return redirect()->route('front.organization_bet_record.detail',$user->id);
        }
                 
        //處理參數資訊
        $type_data = $this->betRecordService->processBetRecordSearchParameters($parameters);

        $data = [
            'datas' => $datas,
            'account_type' => $type_data['account_type'],
            'bet_type' => $type_data['bet_type'],
            'sport_type' => $type_data['sport_type'],
            'range' => config('member.range.'.$parameters['range']),
            'user' => $user,
            'search_result' => $search_result,
            'route_code' => $this->route_code,
            'page_title' => $this->page_title,
            'total_data' => $total_data
        ];
        return view('front.member.'.$this->route_code.'.index',$data); 
    }

    /**
     * 搜尋結果明細
     * @param int $user_id
     * @return view front/member/organization_bet_record/detail.blade.php
     */
    public function detail($user_id)
    {
        $search_result = 'Y';
        $datas = [];
        $record_total = [
            'amount' => 0 ,
            'result_amount' => 0,
            'real_bet_amount' => 0
        ];

        //取得參數
        if (Session::has('m_brecord_param')) {
            $parameters = Session::get('m_brecord_param');
        } else {
            return redirect()->route('front.organization_bet_record.search');
        }
        
        //時間區間
        $date_info = getPeriodDateRange($parameters['range'],0);
        $start = $date_info['start'];
        $end = $date_info['end'];

        $user = $this->userService->find($user_id);
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

        if($user){
            //取得紀錄
            $result = $this->betRecordService->allByMember('member',[
                'member_id' => $user->id,
                'bet_type' => $parameters['bet_type'],
                'sport_type' => $parameters['sport_type'],
                'account_type' => $parameters['account_type'],
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
        $type_data = $this->betRecordService->processBetRecordSearchParameters($parameters);

        $data = [
            'datas' => $datas,
            'account_type' => $type_data['account_type'],
            'bet_type' => $type_data['bet_type'],
            'sport_type' => $type_data['sport_type'],
            'range' => config('member.range.'.$parameters['range']),
            'user' => $user,
            'search_result' => $search_result,
            'route_code' => $this->route_code,
            'page_title' => $this->page_title,
            'record_total' => $record_total,
    	];
        return view('front.member.'.$this->route_code.'.detail',$data); 
    }

    
}
