<?php

namespace App\Http\Controllers\Admin\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Redirect;
use App;
use Session;
use App\Services\Member\BetRecordService;
use App\Services\UserService;
use App\Services\Member\MemberService;
use App\Services\System\ParameterService;
use App\Services\Game\CategoryService;
use Validator;

class OrganizationBetRecordsController extends Controller
{

    /**
     * 參數設定
     *
     * @var string
     */
    protected $betRecordService;
    protected $userService;
    protected $memberService;
    protected $parameterService;
    protected $categoryService;
    protected $page_title = '組織下注歷程';
    protected $menu_title = '組織下注歷程';
    protected $route_code = 'organization_bet_record';
    protected $view_data = [];

    /**
     * 開頭宣告
     *
     * @return void
     */
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
        $this->view_data = [
            'route_code' => $this->route_code,
            'page_title' => $this->page_title,
            'menu_title' => $this->menu_title,
        ];

    }


    /**
     * 總和
     * @param Request $request
     * @return view front/organization_bet_record/index.blade.php
     */
    public function index(Request $request)
    {
        $search_result = 'Y';
        $datas = [];
        $total_data = [];

        //限制最多找到第幾代
        $search_parent_limit = $this->parameterService->find('search_parent_limit'); 

        //紀錄查詢參數
        if($request->has('username')){
            Session::put('a_brecord_param',[
                'range' => $request->range,
                'sport_type' => $request->sport_type,
                'bet_type' => $request->bet_type,
                'account_type' => $request->account_type
            ]);
        } 
        $parameters = Session::get('a_brecord_param');

        //時間區間
        $date_info = getPeriodDateRange($parameters['range'],0);
        $start = $date_info['start'];
        $end = $date_info['end'];

        //取得使用者
        if($request->has('username')){
            $user = $this->userService->getUserByUsername($request->username);
        } else {
            $user = $this->userService->find($request->user_id);
        }
        
        if(!$user){
            $search_result = 'N';
        } else {
            //找樹下線
            $member = $user->member;
            $tree_sub_members = $member->tree_sub_members;
            if(count($tree_sub_members) == 0){
                //無下線，導向明細頁面
                return redirect()->route('admin.member.organization_bet_record.detail',$user->id);
            }

            $parent_level = 'all';

            //取得下線、總和資料
            $sub_result = $this->betRecordService->getSubsBetTotal('admin',$tree_sub_members,$parameters,$start,$end,$parent_level);
            $datas = $sub_result['datas'];
            $total_data = $sub_result['total_data'];
            
            //下線下注筆數都是零，導向明細頁面
            if($total_data['count'] == 0){
                return redirect()->route('admin.member.organization_bet_record.detail',$user->id);
            }
        }

                 
        //處理參數資訊
        $type_data = $this->betRecordService->processBetRecordSearchParameters($parameters);

        $data = [
            'datas' => $datas,
            'account_type' => $type_data['account_type'],
            'bet_type' => $type_data['bet_type'],
            'sport_type' => $type_data['sport_type'],
            'range' => config('member.all_range.'.$parameters['range']),
            'user' => $user,
            'search_result' => $search_result,
            'total_data' => $total_data
        ];

        return view('admin.member.'.$this->route_code.'.index',array_merge($this->view_data,$data));  
    }

    /**
     * 明細
     * @param int $user_id
     * @return view front/organization_bet_record/detail.blade.php
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
        if (Session::has('a_brecord_param')) {
            $parameters = Session::get('a_brecord_param');
        } else {
            return redirect()->route('admin.member.organization_bet_record.search');
        }

        //時間區間
        $date_info = getPeriodDateRange($parameters['range'],0);
        $start = $date_info['start'];
        $end = $date_info['end'];

        //檢查帳號是否存在
        $user = $this->userService->find($user_id);
        if(!$user){
            $search_result = 'N';
        }   

        if($user){
            //取得紀錄
            $result = $this->betRecordService->allByMember('admin',[
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
            'range' => config('member.all_range.'.$parameters['range']),
            'user' => $user,
            'search_result' => $search_result,
            'record_total' => $record_total,
        ];

        return view('admin.member.'.$this->route_code.'.detail',array_merge($this->view_data,$data));  
    }


    /**
     * 搜尋
     *
     * @return view front/organization_bet_record/search.blade.php
     */
    public function search()
    {
        //reset查詢參數
        if (Session::has('a_brecord_param')) {
            Session::forget('a_brecord_param');
        }
        $data=[
            'categories' => $this->categoryService->all()
        ];
        return view('admin.member.'.$this->route_code.'.search',array_merge($this->view_data,$data));  
        
    }


}
