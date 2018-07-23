<?php

namespace App\Http\Controllers\Admin\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Redirect;
use App;
use Session;
use App\Services\Account\AccountService;
use App\Services\UserService;
use App\Services\Member\MemberService;
use Validator;
use Excel;

class AccountsController extends Controller
{

    /**
     * 參數設定
     *
     * @var string
     */
    protected $accountService;
    protected $userService;
    protected $memberService;
    protected $page_title = '會員帳戶明細';
    protected $menu_title = '會員帳戶明細';
    protected $route_code = 'account';
    protected $view_data = [];

    /**
     * 開頭宣告
     *
     * @return void
     */
    public function __construct(
        AccountService $accountService,
        UserService $userService,
        MemberService $memberService
    ) {
        $this->accountService = $accountService;
        $this->userService = $userService;
        $this->memberService = $memberService;
        $this->view_data = [
            'route_code' => $this->route_code,
            'page_title' => $this->page_title,
            'menu_title' => $this->menu_title,
        ];

    }


    /**
     * 明細
     * @param Request $request
     * @return view  admin/member/account/index.blade.php
     */
    public function index(Request $request)
    {
        $search_result = 'Y';
        $own_amount = 0;
        $datas = [];

        //時間區間
        $date_info = getPeriodDateRange($request->range);
        $start = $date_info['start'];
        $end = $date_info['end'];

        //檢查帳號是否存在
        $user = $this->userService->getUserByUsername($request->username);
        if(!$user){
            $search_result = 'N';
        } 

        $data=[
            'account_type' => $request->type,
            'range' => $request->range,
            'search_result' => $search_result,
            'start' => $start,
            'end' => $end
        ];
        if($request->type == 'all'){
            return $this->allAccounts($data,$user);
        } else {
            return $this->oneAccount($data,$user);
        }

    }

    /**
     * 搜尋
     *
     * @return view  admin/member/account/search.blade.php
     */
    public function search()
    {
        $data = [];
        return view('admin.member.'.$this->route_code.'.search',array_merge($this->view_data,$data));  
        
    }

    /**
     * 搜尋結果明細(單一帳戶
     * @param array $data 搜尋資料
     * @param User $user
     * @return view  admin/member/account/one_account.blade.php
     */
    public function oneAccount($data,$user)
    {
        $own_amount = 0;
        if($user){
            //可用餘額
            $accounts = $user->member->accounts;
            $search_account = $accounts->where('type',$data['account_type'])->first();
            $own_amount = $search_account->amount;
            //取得下線總額
            $datas = $this->accountService->allByAccount($search_account->id,$data['start'],$data['end']);

            $data['user'] = $user;
            $data['datas'] = $datas;
            $data['own_amount'] = $own_amount;
        }
        
        
        return view('admin.member.'.$this->route_code.'.one_account',array_merge($this->view_data,$data)); 
    }

    /**
     * 搜尋結果明細(不分帳戶)
     * @param array $data 搜尋資料
     * @param User $user
     * @return view  admin/member/account/all_account.blade.php
     */
    public function allAccounts($data,$user)
    {
        $account = [
            'cash' => 0,
            'run' => 0,
            'interest' => 0,
            'right' => 0
        ];
        if($user){
            //可用餘額
            $accounts = $user->member->accounts;
            //取得下線總額
            $datas = $this->accountService->allRecordByAccountType($user->id,'%',$data['start'],$data['end']);
            $account_amount = [
                'cash' => $accounts->where('type','1')->first()->amount,
                'run' => $accounts->where('type','2')->first()->amount,
                'interest' => $accounts->where('type','4')->first()->amount,
                'right' => $accounts->where('type','3')->first()->amount
            ];

            $data['user'] = $user;
            $data['datas'] = $datas;
            $data['account_amount'] = $account_amount;
        }
        
        
        return view('admin.member.'.$this->route_code.'.all_account',array_merge($this->view_data,$data)); 
    }

    /**
     * 下載excel總表
     * @param date $start
     * @param date $end
     * @return export xls
     */
    public function download($start = null ,$end = null)
    {
        if(!$start || !$end){
            $start = '1970-01-01';
            $end = formatEndDate(date('Y-m-d'));
        }
        $data = [
           'datas' => $this->accountService->allRecordByDateRange($start,$end)
        ];

        $filename = '會員明細總表';
        if($start == '1970-01-01'){
            $filename .= '全部';
        } else {
            $filename .= $start.'-'.$end;
        }

        return Excel::create($filename, function($excel) use($data) {
            $excel->sheet('New sheet', function($sheet) use($data) {
                $sheet->loadView('admin.member.account.report',$data);
            });
        })->export('xls');

    }


}
