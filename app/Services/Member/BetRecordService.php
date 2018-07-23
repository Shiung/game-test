<?php
namespace App\Services\Member;

use App;
use App\Services\System\AdminActivityService;
use App\Repositories\Game\BetRecordRepository;
use App\Services\Game\Sport\Gamble\OverunderService;
use App\Services\Game\Sport\Gamble\SpreadService;
use App\Services\Game\Sport\Gamble\ChooseThreeService;
use App\Services\Game\Sport\Gamble\CnChessNumberService;
use App\Services\Game\Sport\Gamble\CnChessColorService;
use App\Services\Game\CategoryService;
use Illuminate\Support\Facades\DB;
use Exception;
use Auth;
use Session;
use App\Http\Controllers\API\StatController;
use Illuminate\Http\Request;
use App\Http\Requests;
use Log;

class BetRecordService {
    
    protected $adminLog;
    protected $betRecordRepository;
    protected $categoryService;
    protected $statController;
    /**
     * BetRecordService constructor.
     *
     * @param AdminActivityService $adminLog, 
     * @param BetRecordRepository $betRecordRepository
     * @param CategoryService $categoryService
     */
    public function __construct(
        AdminActivityService $adminLog,
        BetRecordRepository $betRecordRepository,
        CategoryService $categoryService,
        StatController $statController
    ) {
        $this->adminLog = $adminLog;
        $this->betRecordRepository = $betRecordRepository;
        $this->categoryService = $categoryService;
        $this->statController = $statController;
    }

    /**
     * 建立賭盤物件
     *
     * @param string $type
     *
     * @return object
     */
    public function createGameObject($type)
    {
        switch ($type) {
            case 1:
                $item =  new OverunderService();
                break;
            case 2:
                $item =  new SpreadService();
                break;
            case 3:
                $item =  new ChooseThreeService();
                 break;
            case 4:
                $item =  new CnChessNumberService();
                break;
            case 5:
                $item =  new CnChessColorService();
                break;
            default:
                # code...
                break;
        }

        return $item;  
    }

    /**
     * 依照id查詢資料
     * @param int $id
     * @return collection
     */
    public function find($id)
    {
        return $this->betRecordRepository->find($id);
    }

    /**
     * 取得下注明細
     * @param string $type
     * @param array $data 
     * @return array
     */
    public function allByMember($type,$data)
    {
        if($type == 'admin'){
            $token = Session::get('a_token');
        } else {
            $token = Session::get('m_token');
        }

        try{

            $data['token'] = $token;
            $data['account_type'] = (string)$data['account_type'];

            $request = new Request($data);
        

            //$result = curlApi(env('API_URL').'/stat/bet_stat_member',$data); 
            $result = $this->statController->bet_stat_member($request);
            
        } catch (Exception $e){

         return ['status' => false, 'error_code'=> 'EXCEPTION_ERROR','error_msg' => $e->getMessage()];
        }

        $result = json_decode($result, true);

        if($result['result'] == 1){
            return ['status' => true ,  'datas' => $result['detail'] ];
        } else {
            return ['status' => false, 'error_code' => $result['error_code'], 'error_msg' => $result['error_msg']];
        }
    }

    /**
     * 取得下注總和
     * @param string $type
     * @param array $data 
     * @return array
     */
    public function getTotalByMember($type,$data)
    {
        if($type == 'admin'){
            $token = Session::get('a_token');
        } else {
            $token = Session::get('m_token');
        }

        try{
            $data['token'] = $token;
            $request = new Request($data);
            //$result = curlApi(env('API_URL').'/stat/bet_stat_tree',$data); 
            $result = $this->statController->bet_stat_tree($request);
        } catch (Exception $e){

         return ['status' => false, 'error_code'=> 'EXCEPTION_ERROR','error_msg' => $e->getMessage()];
        }

        $result = json_decode($result, true);
        if($result['result'] == 1){
            return ['status' => true ,  'data' => $result['detail'] ];
        } else {
            return ['status' => false, 'error_code' => $result['error_code'], 'error_msg' => $result['error_msg'],'detail' => $result['detail']];
        }
    }


    /**
     * 顯示下注內容摘要
     * @param string $type
     * @param int $bet_record_id
     * @return string
     */
    public function showSummary($type,$bet_record_id)
    {
        $record = $this->find($bet_record_id);
        $item = $this->createGameObject($type);
        return $item->showBetRecordSummary($record);   
    }

    /**
     * 取得組織歷程下線總和
     * @param string $type
     * @param array $tree_sub_members
     * @param array $parameters
     * @param date $start
     * @param date $end
     * @return array
     */
    public function getSubsBetTotal($type,$tree_sub_members,$parameters,$start,$end,$parent_level)
    {
        $count = 0;
        $amount = 0;
        $real_bet_amount = 0;
        $result_amount = 0;
        $interest_total = 0;
        $datas = [];
        if($type == 'admin'){
            $token = Session::get('a_token');
        } else {
            $token = Session::get('m_token');
        }

            
        
        //下線列表
        foreach ($tree_sub_members as $sub_member) {
            $sub_interest_total = 0;
            //取得紀錄
            $result = $this->getTotalByMember($type,[
                'member_id' => $sub_member->user_id,
                'bet_type' => $parameters['bet_type'],
                'sport_type' => $parameters['sport_type'],
                'account_type' => $parameters['account_type'],
                'start_date' => $start,
                'end_date' => $end,
                'level' => $parent_level
            ]);

            $result = $result['data'];

            //筆數>0 加總
            if($result['count'] > 0){
                $count = $count + $result['count'];
                $amount = $amount + $result['amount'];
                $real_bet_amount = $real_bet_amount + $result['real_bet_amount'];
                $result_amount = $result_amount + $result['result_amount'];

                //取得利息碼
                $interest_result = curlApi(env('API_URL').'/stat/stat_tree',[
                    'token' => $token,
                    'start_date' => $start,
                    'end_date' => $end,
                    'level' => $parent_level,
                    'member_id' => $sub_member->user_id,
                    'type' => 'receive_center_4'
                ]);
                $interest_result = json_decode($interest_result, true);
                if($interest_result['result'] == 1){
                    $sub_interest_total = $interest_result['detail']['amount'];
                    if($sub_interest_total > 0){
                        $interest_total = $interest_total + $sub_interest_total;
                    }
                } 
            } 

            //新增下線資訊
            array_push($datas,[
                'user_id' => $sub_member->user_id,
                'name' => $sub_member->name,
                'username' => $sub_member->user->username,
                'count' => $result['count'],
                'amount' => $result['amount'],
                'real_bet_amount' => $result['real_bet_amount'],
                'result_amount' => $result['result_amount'],
                'sub_interest_total' => $sub_interest_total,
            ]);
            
        }

        //總計
        $total_data = [
            'count' => $count,
            'amount' => $amount,
            'real_bet_amount' => $real_bet_amount,
            'result_amount' => $result_amount,
            'interest_total' => $interest_total
        ];
        return ['datas' => $datas, 'total_data' => $total_data];
   
    }

    /**
     * 處理下注搜尋資訊
     * @param array $parameters
     * @return array
     */
    public function processBetRecordSearchParameters($parameters)
    {
        ($parameters['sport_type'] == 'all')?($sport_type = '全部'):($sport_type =  $this->categoryService->find($parameters['sport_type'])->name);
        ($parameters['bet_type'] == 'all')?($bet_type = '全部'):($bet_type = config('game.sport.game.type.'.$parameters['bet_type']));
        ($parameters['account_type'] == 'all')?($account_type = '全部'):($account_type = config('member.account.type.'.$parameters['account_type']));
        
        return [
            'sport_type' => $sport_type,
            'bet_type' => $bet_type,
            'account_type' => $account_type
        ];
    }

  
}
