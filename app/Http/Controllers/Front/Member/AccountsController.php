<?php

namespace App\Http\Controllers\Front\Member;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Account\AccountService;
use App\Services\UserService;
use App\Services\Member\MemberService;
use App\Services\System\ParameterService;
use App;
use Auth;
use Validator;

class AccountsController extends Controller
{

    protected $accountService;
    protected $userService;
    protected $memberService;
    protected $parameterService;
    protected $user;
    protected $page_title = '帳戶明細';
    protected $route_code = 'account';
    
	public function __construct(
        AccountService $accountService,
        UserService $userService,
        MemberService $memberService,
        ParameterService $parameterService
    ) {
        $this->accountService = $accountService;
        $this->userService = $userService;
        $this->memberService = $memberService;
        $this->parameterService = $parameterService;
        $this->user = Auth::guard('web')->user();     
        
    }

    /**
     * 搜尋頁面
     *
     * @return view front/member/account/search.blade.php
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
     * @return function
     */
    public function index(Request $request)
    {
        $search_result = 'Y';
        $subs_total_amount = 0;
        $own_amount = 0;
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
                    if($check_tree['in_tree'] == 1 && $check_tree['level'] > $this->parameterService->find('search_parent_limit')){
                        $search_result = 'N';
                    }
                } else {
                    $search_result = 'N';
                }
            }   

        }


    	$data=[
            'account_type' => $request->type,
            'range' => $request->range,
            'search_result' => $search_result,
            'route_code' => $this->route_code,
            'page_title' => $this->page_title,
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
     * 搜尋結果明細(單一帳戶)
     * @param array $data 搜尋資料
     * @param User $user
     * @return view front/member/account/one_account.blade.php
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
        
        
        return view('front.member.'.$this->route_code.'.one_account',$data); 
    }

    /**
     * 搜尋結果明細(不分帳戶)
     * @param array $data 搜尋資料
     * @param User $user
     * @return view front/member/account/all_account.blade.php
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
        
        
        return view('front.member.'.$this->route_code.'.all_account',$data); 
    }
    
}
