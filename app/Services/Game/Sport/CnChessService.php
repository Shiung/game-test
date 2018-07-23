<?php
namespace App\Services\Game\Sport;

use App;
use App\Services\Game\Sport\SportService;
use App\Repositories\Game\SportRepository;
use App\Repositories\Game\CnChessRepository;
use App\Services\Game\Sport\SportGameService;
use App\Repositories\Game\BetRecordRepository;
use App\Repositories\Game\CategoryRepository;
use App\Services\System\AdminActivityService;
use App\Services\Game\Sport\Gamble\CnChessNumberService;
use Illuminate\Support\Facades\DB;
use Exception;
use Session;

class CnChessService extends SportService{
    
    protected $sportRepository;
    protected $cnChessRepository;
    protected $sportGameService;
    protected $betRecordRepository;
    protected $categoryRepository;
    protected $adminLog;
    
    /**
     * CnChessService constructor.
     *
     * @param AdminActivityService $log,
     * @param SportRepository $sportRepository
     * @param SportGameService $sportGameService
     * @param BetRecordRepository $betRecordRepository
     * @param CnChessRepository $cnChessRepository
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(
        AdminActivityService $adminLog,
        SportRepository $sportRepository,
        SportGameService $sportGameService,
        BetRecordRepository $betRecordRepository,
        CnChessRepository $cnChessRepository,
        CategoryRepository $categoryRepository
    ) {
        $this->adminLog = $adminLog;
        $this->sportRepository = $sportRepository;
        $this->betRecordRepository = $betRecordRepository;
        $this->sportGameService = $sportGameService;
        $this->categoryRepository = $categoryRepository;
        $this->cnChessRepository = $cnChessRepository;
        parent::__construct($adminLog,$sportRepository,$categoryRepository,$sportGameService);
    }

   
    /**
     *  取得所有資料
     * @param date $start
     * @param date $end
     * @return collection 
     */
    public function allGames($start = null,$end = null,$paginate = 1)
    {
        if($start == null && $end == null){
            $datas =  $this->cnChessRepository->all();
        } else {
            $datas =  $this->cnChessRepository->all($start,formatEndDate($end),$paginate);
        
        }
        return $datas;
        
    }

    /**
     *  取得最新的象棋場次
     * @return collection 
     */
    public function getLatestGame()
    {

        return $this->cnChessRepository->getLatestGame();
    }

    /**
     * 檢查下注/開獎號碼是否符合規則
     * @param array $numbers
     * @param string $type
     * @return bool
     */
    public function checkIfNumbersValid($numbers,$type = 'number')
    {
        if($type == 'number'){
            return checkNumbersRangeValid($numbers,1,22);
        } else {
            return checkNumbersRangeValid($numbers,0,1);
        }
        
    }

    /**
     * 下注
     * @param array $data
     * @return array
     */
    public function bet($data)
    {   
        $bet_data = $this->getFormatBetData($data["sport_id"],$data['records']);
        $send_data = [
           'bets' => json_encode($bet_data), 
        ];
        $send_data['token'] = Session::get('m_token');
        return $send_data;
        /*try{   
            $bet_data = $this->getFormatBetData($data["sport_id"],$data['records']);
            $send_data = [
               'bets' => json_encode($bet_data), 
            ];
            $send_data['token'] = Session::get('m_token');
            $result = curlApi(env('API_URL').'/sport/bet_multi',$send_data); 
        } catch (Exception $e){
            return ['status' => false, 'error_code' =>'System Error', 'error_msg'=> $e->getMessage()];
        }
        $result = json_decode($result, true);
        if($result['result'] == 1){
            $content = $this->getBetSuccessInfo($result['bet_record_ids']);
            return ['status' => true ,'content' => $content];
        } else {
            return ['status' => false, 'error_code' => $result['error_code'], 'error_msg' => $result['error_msg'],'detail' => $result['detail']];
        }*/
        
    }

    /**
     * 下注成功回傳資訊
     * @param array $ids
     * @return array
     */
    public function getBetSuccessInfo($ids)
    {
        $records  = [];
        foreach ($ids as $record_id) {
            $record = $this->betRecordRepository->find($record_id);
            array_push($records,[
                'amount' => $record->amount,
                'account_name' => config('member.account.type.'.$record->account->type),
                'bet_number'=> $record->bet_number,
                'created_at'=> $record->bet_time
            ]);
        }
        $data['records'] = $records;
        return $data;
    }

    /**
     * 取得整理過後的下注資料
     * @param int $sport_id
     * @param array $records
     * @return array
     */
    private function getFormatBetData($sport_id,$records)
    {
        $bet_data = [];
        //取得賭盤相關資料
        $sport = $this->find($sport_id);
        $games = $sport->games;


        //選數字
        //取得賠率
        $number_game = $games->where('type',4)->first();
        $number_game_detail = $this->sportGameService->find($number_game['id'])->detail;
        $number_info_data = [
            'one_ratio' => $number_game_detail->one_ratio,
            'two_ratio' => $number_game_detail->two_ratio,
            'virtual_cash_ratio' => $number_game_detail->virtual_cash_ratio,
            'share_ratio' => $number_game_detail->share_ratio
        ];

        //選顏色

        //取得賠率
        $color_game = $games->where('type',5)->first();
        $color_game_detail = $this->sportGameService->find($color_game['id'])->detail;
        $color_info_data = [
            'black_ratio' => $color_game_detail->black_ratio,
            'red_ratio' => $color_game_detail->red_ratio,
        ];

        foreach ($records as $key => $record) {
            //取得下注籌碼資料
            $amount_data = $this->getFormatAmountData($record);
            if($key == 'red' || $key == 'black'){
                if($key == 'red'){
                    $gamble = 0;
                } else {
                    $gamble = 1;
                }
                $color_info_data['gamble'] = $gamble;
                $format_data = $this->sportGameService->getFormatBetData(5,$color_game['id'],$amount_data,$color_info_data);
            } else {
                $number_info_data['numbers'] = config('cn_chess.chess_to_number.'.$key.'.numbers');
                $format_data = $this->sportGameService->getFormatBetData(4,$number_game['id'],$amount_data,$number_info_data);
            
            }
            $format_data['token'] = Session::get('m_token');
            array_push($bet_data,$format_data);
        }



        return $bet_data;

    }

    /**
     * 取得整理過的下注籌碼資料
     * @param $data
     * @return string
     */
    private function getFormatAmountData($data)
    {
        $virtual_cash_amount = 0;
        $manage_amount = 0;
        $share_amount = 0;
        $interest_amount = 0;
        if(array_key_exists("1",$data)){
            $virtual_cash_amount = $data['1']['total'];
        }
        if(array_key_exists("2",$data)){
            $manage_amount = $data['2']['total'];
        }
        if(array_key_exists("3",$data)){
            $share_amount = $data['3']['total'];
        }
        if(array_key_exists("4",$data)){
            $interest_amount = $data['4']['total'];
        }

        //處理下注金額
        $amount_data = [
            '1' => (int)$virtual_cash_amount,
            '2' => (int)$manage_amount,
            '3' => (int)$share_amount,
            '4' => (int)$interest_amount
        ];

        return json_encode($amount_data);


    }
    
  
}
