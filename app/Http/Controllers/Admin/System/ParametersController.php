<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Services\System\ParameterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;

class ParametersController extends Controller
{
    /**
     * 參數設定
     *
     * @var string
     */
    protected $parameterService;
    protected $page_title = '參數設定';
    protected $menu_title = '參數設定';
    protected $route_code = 'parameter';
    protected $view_data = [];


    /**
     * 開頭宣告
     *
     * @return void
     */
    public function __construct(ParameterService $parameterService)
    {
        $this->parameterService = $parameterService;
        $this->view_data = [
            'route_code' => $this->route_code,
            'page_title' => $this->page_title,
            'menu_title' => $this->menu_title,
        ];

    }
    
    /**
     * 所有資料頁面
     * 
     * @return view admin/system/parameter/index.blade.php
     */
    public function index()
    {
        $parameters = [
            'sms_expire_second' => $this->parameterService->find('sms_expire_second'),
            'tree_parent' => $this->parameterService->find('tree_parent'),
            'bet_status_closetime' => $this->parameterService->find('bet_status_closetime'),
            'sport_starttime_539' => $this->parameterService->find('sport_starttime_539'),
            'sport_game_starttime_539' => $this->parameterService->find('sport_game_starttime_539'),
            'one_ratio_539' => $this->parameterService->find('one_ratio_539'),
            'two_ratio_539' => $this->parameterService->find('two_ratio_539'),
            'three_ratio_539' => $this->parameterService->find('three_ratio_539'),
            'bet_opentime' => $this->parameterService->find('bet_opentime'),
            'daily_interest_period' => $this->parameterService->find('daily_interest_period'),
            'bet_bonus_interest' => $this->parameterService->find('bet_bonus_interest'),
            'one_ratio_539' => $this->parameterService->find('one_ratio_539'),
            'bet_bonus_level' => $this->parameterService->find('bet_bonus_level'),
            'bet_bonus_period' => $this->parameterService->find('bet_bonus_period'),
            'recommend_bonus_interest' => $this->parameterService->find('recommend_bonus_interest'),
            'recommend_bonus_period' => $this->parameterService->find('recommend_bonus_period'),
            'tree_bonus_interest' => $this->parameterService->find('tree_bonus_interest'),
            'tree_bonus_level' => $this->parameterService->find('tree_bonus_level'),
            'tree_bonus_period' => $this->parameterService->find('tree_bonus_period'),
            'daily_interest_schedule' => $this->parameterService->find('daily_interest_schedule'),
            'daily_recommend_schedule' => $this->parameterService->find('daily_recommend_schedule'),
            'monthly_bet_schedule' => $this->parameterService->find('monthly_bet_schedule'),
            'monthly_tree_schedule' => $this->parameterService->find('monthly_tree_schedule'),
            'search_parent_limit' => $this->parameterService->find('search_parent_limit'),
            'interest_cleartime' => $this->parameterService->find('interest_cleartime'),
            'block_member_period' => $this->parameterService->find('block_member_period'),
            'web_status' => $this->parameterService->find('web_status'),
            'maintenance_start' => $this->parameterService->find('maintenance_start'),
            'maintenance_end' => $this->parameterService->find('maintenance_end'),
            'tree_subs_total_show' => $this->parameterService->find('tree_subs_total_show'),
            'cn_chess_one_ratio' => $this->parameterService->find('cn_chess_one_ratio'),
            'cn_chess_two_ratio' => $this->parameterService->find('cn_chess_two_ratio'),
            'cn_chess_virtual_cash_ratio' => $this->parameterService->find('cn_chess_virtual_cash_ratio'),
            'cn_chess_share_ratio' => $this->parameterService->find('cn_chess_share_ratio'),
            'cn_chess_red_ratio' => $this->parameterService->find('cn_chess_red_ratio'),
            'cn_chess_black_ratio' => $this->parameterService->find('cn_chess_black_ratio'),
            'cn_chess_interval' => $this->parameterService->find('cn_chess_interval'),
            'cn_chess_resttime' => $this->parameterService->find('cn_chess_resttime'),
            'share_transaction_fee_percent' => $this->parameterService->find('share_transaction_fee_percent'),
            'share_transaction_expire_day' => $this->parameterService->find('share_transaction_expire_day'),
            'daily_interest_max' => $this->parameterService->find('daily_interest_max'),
            'sub_delete_cash_min' => $this->parameterService->find('sub_delete_cash_min'),
            'sub_delete_share_min' => $this->parameterService->find('sub_delete_share_min'),
            'sub_delete_manage_min' => $this->parameterService->find('sub_delete_manage_min'),
        ];
        $data =[
            'parameters' => $parameters
        ];
        return view('admin.system.'.$this->route_code.'.index',array_merge($this->view_data,$data));
    }

    /**
     * 更新
     * @param Request $request
     * @return json
     */
    public function update(Request $request)
    {
        $result = $this->parameterService->update($request->parameters);
        if ( $result['status']) {
            return json_encode(array('result' => 1, 'text' => 'Success'));
        } else {
            return json_encode(array('result' => 0, 'text' => $result['error']));
        } 
    }




}
