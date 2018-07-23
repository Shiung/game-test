<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Services\API\RoleService;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Services\API\TreeService;
use App\Services\API\BonusService;
use App\Services\API\StatService;
use App\Models\Tree;
use Exception;
use DB;

class StatController extends Controller
{
    //
	protected $roleService;
    protected $treeService;
    protected $bonusService;
    protected $statService;
    
    public function __construct(RoleService $roleService, TreeService $treeService, BonusService $bonusService, StatService $statService)
    {
        
        $this->roleService = $roleService;
        $this->treeService = $treeService;
        $this->bonusService = $bonusService;
        $this->statService = $statService;

    }


    //個人下紀錄
    public function bet_stat_member(Request $request)
    {
        $input = $request->all();
        
        //欄位檢查
        $this->roleService->column_validate($input, [
            'token' => 'required',
            'member_id' => 'required|min:0|integer',
            'account_type' => 'required',
            'sport_type' => 'required',
            'bet_type' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        try{
            $member_ids = [];
            //$period = $this->statService->period_date($input['period']);
            array_push($member_ids,$input['member_id']);

            $r = $this->statService->bet_record($input['start_date'],$input['end_date'],$member_ids,$input['bet_type'],$input['account_type'],$input['sport_type'])->get();
            
        }catch(Exception $e){            
            return response()->json(['result'=>0, 'error_code'=>'ERROR', 'error_msg'=>'查詢失敗', 'detail'=>$e->getMessage()]);
        }

        //return response()->json(['result'=>1, 'success_msg'=>'查詢成功', 'detail'=>$r]);
        return json_encode(['result'=>1, 'success_msg'=>'查詢成功', 'detail'=>$r]);
    }


    //組織下線紀錄
    public function bet_stat_tree(Request $request)
    {
        $input = $request->all();
        
        //欄位檢查
        $this->roleService->column_validate($input, [
            'token' => 'required',
            'member_id' => 'required|min:0|integer',
            'account_type' => 'required',
            'sport_type' => 'required',
            'bet_type' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'level' => 'required|not_in:0',
        ]);

        try{
            $has_member = Tree::where('parent_id',$input['member_id'])->get();
            $member_ids = [];

            if(!$has_member->isEmpty() && $input['level']!=0){
                //產生所有下線id
                if($input['level']=='all')
                    $level = null;
                else
                    $level = $input['level'];
                $this->treeService->createtree($input['member_id'],$level);
                $member_ids = $this->treeService->treelist["member"];
            }

            array_push($member_ids,$input['member_id']);
            $r = $this->statService->bet_record($input['start_date'],$input['end_date'],$member_ids,$input['bet_type'],$input['account_type'],$input['sport_type']);
            //print_r($r);
            $sum = [
                'count' => $r->count(),
                'amount' => $r->sum('sport_bet_records.amount'),
                'real_bet_amount' => $r->sum('real_bet_amount'),
                'result_amount' => $r->sum('result_amount'),
            ];
            
        }catch(Exception $e){            
            return response()->json(['result'=>0, 'error_code'=>'ERROR', 'error_msg'=>'查詢失敗', 'detail'=>$e->getMessage()]);
        }
        return json_encode(['result'=>1, 'success_msg'=>'查詢成功', 'detail'=>$sum]);
        //return response()->json(['result'=>1, 'success_msg'=>'查詢成功', 'detail'=>$sum]);
    }


    //統計 日月週
    public function stat_date(Request $request)
    {
        $input = $request->all();
        
        //欄位檢查
        $this->roleService->column_validate($input, [
            'token' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'period_type' => 'required|In:d,m,y,w',
            'type' => 'required|In:product,receive_center_2,receive_center_4,account_1,account_2,account_3,account_4,account_5,game',
        ]);

        try{
            switch ($input['type']) {
                //商城支出
                case 'product':
                    $r = $this->statService->product_date($input['start_date'], $input['end_date'], $input['period_type']);
                    break;

                //領取中心經營馬
                case 'receive_center_2':
                    $r = $this->statService->receive_center_date($input['start_date'], $input['end_date'], $input['period_type'], [3], [2]);
                    break;
                
                //領取中心利息馬
                case 'receive_center_4':
                    $r = $this->statService->receive_center_date($input['start_date'], $input['end_date'], $input['period_type'], [3], [4]);
                    break;

                //現金幣 進出帳
                case 'account_1':
                    $record_types = range(0,20);
                    $r = $this->statService->receive_center_date($input['start_date'], $input['end_date'], $input['period_type'], $record_types, [1]);
                    break;

                //經營幣 進出帳
                case 'account_2':
                    $record_types = range(0,20);
                    $r = $this->statService->receive_center_date($input['start_date'], $input['end_date'], $input['period_type'], $record_types, [2]);
                    break;

                //權利幣 進出帳
                case 'account_3':
                    $record_types = range(0,20);
                    $r = $this->statService->receive_center_date($input['start_date'], $input['end_date'], $input['period_type'], $record_types, [3]);
                    break;

                //利息幣 進出帳
                case 'account_4':
                    $record_types = range(0,20);
                    $r = $this->statService->receive_center_date($input['start_date'], $input['end_date'], $input['period_type'], $record_types, [4]);
                    break;

                //賭盤
                case 'game':
                    $r = $this->statService->bet_game_record($input['start_date'], $input['end_date'], $input['period_type']);
                    break;

                default:
                    # code...
                    break;
            }

        }catch (Exception $e){
            return response()->json(['result'=>0, 'error_code'=>'ERROR', 'error_msg'=>'查詢失敗', 'detail'=>$e->getMessage()]);
        }

        return response()->json(['result'=>1, 'success_msg'=>'查詢成功', 'detail'=>$r]);

    }


    //統計 member
    public function stat_member(Request $request)
    {
        $input = $request->all();
        
        //欄位檢查
        $this->roleService->column_validate($input, [
            'token' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'type' => 'required|In:product,receive_center_2,receive_center_4,account_1,account_2,account_3,account_4,account_5',
        ]);

        try{
            switch ($input['type']) {
                //商城支出
                case 'product':
                    $r = $this->statService->receive_center_member($input['start_date'], $input['end_date'],[7],[1,2,3,4]);
                    break;

                //領取中心經營馬
                case 'receive_center_2':
                    $r = $this->statService->receive_center_member($input['start_date'], $input['end_date'], [3], [2]);
                    break;
                
                //領取中心利息馬
                case 'receive_center_4':
                    $r = $this->statService->receive_center_member($input['start_date'], $input['end_date'], [3], [4]);
                    break;

                //現金幣 進出帳
                case 'account_1':
                    $record_types = range(0,20);
                    $r = $this->statService->receive_center_member($input['start_date'], $input['end_date'], $record_types, [1]);
                    break;

                //經營幣 進出帳
                case 'account_2':
                    $record_types = range(0,20);
                    $r = $this->statService->receive_center_member($input['start_date'], $input['end_date'], $record_types, [2]);
                    break;

                //權利幣 進出帳
                case 'account_3':
                    $record_types = range(0,20);
                    $r = $this->statService->receive_center_member($input['start_date'], $input['end_date'], $record_types, [3]);
                    break;

                //利息幣 進出帳
                case 'account_4':
                    $record_types = range(0,20);
                    $r = $this->statService->receive_center_member($input['start_date'], $input['end_date'], $record_types, [4]);
                    break;

                default:
                    # code...
                    break;
            }

        }catch (Exception $e){
            return response()->json(['result'=>0, 'error_code'=>'ERROR', 'error_msg'=>'查詢失敗', 'detail'=>$e->getMessage()]);
        }

        return response()->json(['result'=>1, 'success_msg'=>'查詢成功', 'detail'=>$r]);

    }


    //統計 tree
    public function stat_tree(Request $request)
    {
        $input = $request->all();
        
        //欄位檢查
        $this->roleService->column_validate($input, [
            'token' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'member_id' => 'required|min:0|integer',
            'type' => 'required|in:receive_center_2,receive_center_4',
            'level' => 'required|not_in:0',
        ]);

        
        try{
            //找到下限id
            $member_ids = [];
            $has_member = Tree::where('parent_id',$input['member_id'])->get();
    
            //如果有下線
            if(!$has_member->isEmpty()){
                //產生所有下線id
                if($input['level']=='all')
                    $level = null;
                else
                    $level = $input['level'];

                $this->treeService->createtree($input['member_id'], $level);
                $member_ids = $this->treeService->treelist["member"];
                //print_r($member_ids);
            }

            array_push($member_ids, $input['member_id']);

            //統計
            switch ($input['type']) {

                //找出下線在領取中心領的利息
                case 'receive_center_4':
                    $r = $this->statService->receive_center($input['start_date'], $input['end_date'], [3], [4],$member_ids);
                    break;

                //找出下線在領取中心領的經營幣
                case 'receive_center_2':
                    $r = $this->statService->receive_center($input['start_date'], $input['end_date'], [3], [2],$member_ids);
                    break;

                default:
                    # code...
                    break;
            }

        }catch (Exception $e){
            return response()->json(['result'=>0, 'error_code'=>'ERROR', 'error_msg'=>'查詢失敗', 'detail'=>$e->getMessage()]);
        }

        return response()->json(['result'=>1, 'success_msg'=>'查詢成功', 'detail'=>$r]);
    }


    //統計cn_chess單一期別下注
    public function stat_cnchess_bet(Request $request)
    {
        $input = $request->all();
        
        //欄位檢查
        $this->roleService->column_validate($input, [
            'token' => 'required',
            'sport_id' => 'required',
        ]);

        try{
            $user = JWTAuth::toUser($input['token']);
            $r = $this->statService->chess_bet_one($user->id, $input['sport_id']);
        }catch (Exception $e){
            return response()->json(['result'=>0, 'error_code'=>'ERROR', 'error_msg'=>'查詢失敗', 'detail'=>$e->getMessage()]);
        }

        //return view('welcome')
        return response()->json(['result'=>1, 'success_msg'=>'查詢成功', 'detail'=>$r]);  
    }
    
}
