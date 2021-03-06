<?php

namespace App\Http\Controllers\Admin\Statistic;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Services\Statistic\RevenueService;
use App\Services\Account\AccountService;
use App\Services\Member\MemberService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;

class ShopRevenuesController extends Controller
{
    /**
     * 參數設定
     *
     * @var string
     */
    protected $statisticService;
    protected $accountRecordService;
    protected $memberService;
    protected $page_title = '商城營收';
    protected $menu_title = '商城營收';
    protected $route_code = 'shop_revenue';
    protected $view_data = [];
    protected $view_path = 'revenue';


    /**
     * 開頭宣告
     *
     * @return void
     */
    public function __construct(
        RevenueService $statisticService, 
        AccountService $accountRecordService, 
        MemberService $memberService
    ) {
        $this->statisticService = $statisticService;
        $this->accountRecordService = $accountRecordService;
        $this->memberService = $memberService;
        $this->view_data = [
            'route_code' => $this->route_code,
            'page_title' => $this->page_title,
            'menu_title' => $this->menu_title,
        ];

    }
    
    /**
     * 摘要頁面
     * @param date $start
     * @param date $end
     * @param string $period_type 時間區間類型
     * @return view admin/statistic/revenue/summary.blade.php
     */
    public function summary($start = null, $end = null, $period_type = 'd')
    {
        if(!$start || !$end){
            $date_info = getDefaultDateRange(6);
            $start = $date_info['start'];
            $end = $date_info['end'];
        }
    	$result = $this->statisticService->getStatByRange($start,$end,'product',$period_type); 
        $data =[
            'datas' => $result['datas'],
            'total' => abs(sumDataAmount($result['datas']) ),
            'start' => $start,
            'end' => $end,
            'period_type' => $period_type
        ];
        return view('admin.statistic.'.$this->view_path.'.summary',array_merge($this->view_data,$data));
    }

    /**
     * 會員列表頁面
     * @param date $start
     * @param date $end
     * @return view admin/statistic/revenue/members.blade.php
     */
    public function members($start, $end)
    {
        $end = date("Y-m-d", strtotime("-1 days",strtotime($end)));
        $result = $this->statisticService->getMemberStatByRange($start,$end,'product'); 
        
        $data =[
            'datas' => $result['datas'],
            'start' => $start,
            'end' => $end,
            'total' => abs(sumDataAmountByKey($result['datas'],'stcount') ),
        ];
        return view('admin.statistic.'.$this->view_path.'.members',array_merge($this->view_data,$data));
    }

    /**
     * 單一會員明細頁面
     * @param int $user_id
     * @param date $start
     * @param date $end
     * @return view admin/statistic/revenue/detail.blade.php
     */
    public function detail($user_id, $start, $end)
    {
        $member = $this->memberService->find($user_id);
        if(!$member){
            abort(404);
        }
        $accounts = $member->accounts;
        $account = $accounts->where('type','1')->first();
        $datas = $this->accountRecordService->allByAccountType($account->id,'7',$start,$end); 
        $data =[
            'datas' => $datas,
            'start' => $start,
            'end' => $end,
            'member' => $member,
            'total' => abs(sumDataAmountByKey($datas,'amount') ),
        ];

        return view('admin.statistic.'.$this->view_path.'.detail',array_merge($this->view_data,$data));
    }




}
