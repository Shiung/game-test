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

class BetRecordsController extends Controller
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
    protected $page_title = '會員下注紀錄';
    protected $menu_title = '會員下注紀錄';
    protected $route_code = 'bet_record';
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
     * 明細
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
        /*$date_info = getPeriodDateRange($request->range,0);
        $start = $date_info['start'];
        $end = $date_info['end'];*/
        $start = $request->start;
        $end = formatEndDate($request->end);

        //檢查帳號是否存在
        $users = $this->userService->getUserByUsername($request->username,'like');
        if(count($users) == 0){
            $search_result = 'N';
        } else {
            foreach ($users as $user) {
                //取得紀錄
                $result = $this->betRecordService->allByMember('admin',[
                    'member_id' => $user->id,
                    'bet_type' => $request->bet_type,
                    'sport_type' => $request->sport_type,
                    'account_type' => $request->account_type,
                    'start_date' => $start,
                    'end_date' => $end
                ]);

                //加總
                $record_total['amount'] = $record_total['amount']+sumDataAmountByKey($result['datas'],'amount');
                $record_total['result_amount'] = $record_total['result_amount']+sumDataAmountByKey($result['datas'],'result_amount');
                $record_total['real_bet_amount'] = $record_total['real_bet_amount']+sumDataAmountByKey($result['datas'],'real_bet_amount');
                $datas = array_merge($datas, $result['datas']);
            }
            
        }   

        
        //處理參數資訊
        $type_data = $this->betRecordService->processBetRecordSearchParameters($request->all());
        $data = [
            'datas' => $datas,
            'account_type' => $type_data['account_type'],
            'bet_type' => $type_data['bet_type'],
            'sport_type' => $type_data['sport_type'],
            'range' => $request->start.'~'.$request->end,
            'username' => $request->username,
            'search_result' => $search_result,
            'record_total' => $record_total,
        ];

        return view('admin.member.'.$this->route_code.'.index',array_merge($this->view_data,$data));  
    }

    /**
     * 搜尋
     *
     * @return view front/member/bet_record/search.blade.php
     */
    public function search()
    {
        $data=[
            'categories' => $this->categoryService->all()
        ];
        return view('admin.member.'.$this->route_code.'.search',array_merge($this->view_data,$data));  
        
    }


}
