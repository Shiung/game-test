<?php
namespace App\Services\Game\Sport;

use App;
use App\Repositories\Game\SportGameRepository;
use App\Repositories\Game\BetRecordRepository;
use App\Services\System\AdminActivityService;
use App\Services\Game\Sport\Factory\SportGameFactory;
use Illuminate\Support\Facades\DB;
use Exception;
use Session;
use App\Models\Sport\SportGame;
use App\Models\Sport\Sport;

class SportGameService {
    
    protected $sportGameRepository;
    protected $betRecordRepository;
    protected $adminLog;
    protected $type = '';
    protected $feature_name = '賭盤';
    
    /**
     * SportService constructor.
     *
     * @param AdminActivityService $log,
     * @param SportGameRepository $sportGameRepository,
     * @param BetRecordRepository $betRecordRepository
     */
    public function __construct(
        AdminActivityService $adminLog,
        SportGameRepository $sportGameRepository,
        BetRecordRepository $betRecordRepository
    ) {
        $this->adminLog = $adminLog;
        $this->sportGameRepository = $sportGameRepository;
        $this->betRecordRepository = $betRecordRepository;
    }

    /**
     *  設置賽程類型
     *  @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     *  ================
     *  賭盤
     *  ================
     */
    /**
     *  取得所有資料
     * @param int $category_id
     * @param array $status
     * @param date $start
     * @param date $end
     * @return collection 
     */
    public function all($category_id,$status = '%',$start = null,$end = null)
    {
        if($start == null && $end == null){
            return $this->sportGameRepository->all($category_id,$status);
        } else {
            return $this->sportGameRepository->all($category_id,$status,$start,formatEndDate($end));
        
        }
        
    }
    

    /**
     * 依照id查詢資料
     * @param int $id
     * @return collection
     */
    public function find($id)
    {
        return $this->sportGameRepository->find($id);
    }

    /**
     * 更新
     * @param string $type
     * @param array $data
     * @param int $id
     * @return collection
     */
    public function update($type,$data,$id = null)
    {
        $item = SportGameFactory::create($type);
        return $item->update($data,$id);   
    }


    /**
     * 更新下注狀態
     * @param int  $bet_status
     * @param int $id
     * @return collection
     */
    public function changeStatus($bet_status,$id)
    {
        try{
            $send_data = [
               'bet_status' => $bet_status, 
               'sport_game_id' => $id, 
            ];
            $send_data['token'] = Session::get('a_token');
            
            $result = curlApi(env('API_URL').'/sport/change_bet_status',$send_data); 
        } catch (Exception $e){
         return ['status' => false, 'error_code' =>'System Error', 'error_msg'=> $e->getMessage()];
        }
        $result = json_decode($result, true);
        if($result['result'] == 1){
            return ['status' => true];
        } else {
            return ['status' => false, 'error_code' => $result['error_code'], 'error_msg' => $result['error_msg']];
        }
    }

    /**
     * 新增
     * @param array $data
     * @return collection
     */
    public function add($type,$data)
    {   
        $item = SportGameFactory::create($type);
        return $item->add($data);   
    }
    
    /**
     * 刪除
     * @param int $id
     * @return collection
     */
    public function delete($id)
    {
        try{
            $send_data = [
               'sport_game_id' => $id, 
            ];
            $send_data['token'] = Session::get('a_token');
            
            $result = curlApi(env('API_URL').'/sport/delete_sport_game',$send_data); 
        } catch (Exception $e){
         return ['status' => false, 'error_code' =>'System Error', 'error_msg'=> $e->getMessage()];
        }
        $result = json_decode($result, true);
        if($result['result'] == 1){
            return ['status' => true];
        } else {
            return ['status' => false, 'error_code' => $result['error_code'], 'error_msg' => $result['error_msg']];
        }
    }

    
    /**
     * 顯示後台的賭盤內容摘要
     *
     * @param string $type
     * @param SportGame $game
     *
     * @return string
     */
    public function show($type,SportGame $game)
    {
        $item = SportGameFactory::create($type);
        return $item->showGameSummary($game);   
    }

    /**
     * 檢查參數是否完整
     *
     * @param string $type
     * @param SportGame $game
     *
     * @return bool
     */
    public function checkParameterComplete($type,SportGame $game)
    {
        //賭盤詳細參數
        $detail = $game->detail;
        if(!$detail){
            return false;
        }

        $item = SportGameFactory::create($type);
        return $item->checkParameterComplete($detail->toArray());   
    }

    /**
     * 回傳單一賽程的玩法列表（for前台）
     *
     * @param Sport $sport
     *
     * @return array
     */
    public function showGamesBySport(Sport $sport)
    {
        $arr = [];
        foreach ($sport->games as $game) {
            if($game->bet_status == '1' ){
                $code = config('game.sport.game.number_to_code.'.$game->type);
                $arr[$code] = $this->getGameParameter($game->type,$game,$sport,$sport->teams);
            }
            
        }
        return $arr;
    }

    /**
     * 回傳單一玩法參數（for前台）
     *
     * @param string $type
     * @param SportGame $game
     * @param Sport $sport
     * @param array $teams
     *
     * @return array
     */
    public function getGameParameter($type,SportGame $game,Sport $sport,$teams = [])
    {
        $item = SportGameFactory::create($type);
        return $item->getGameParameter($game,$sport,$teams);   
    }

    /**
     * 前台的賭盤資訊
     *
     * @param string $type
     * @param SportGame $game
     *
     * @return array
     */
    public function showGameRule($type,SportGame $game)
    {
        $item = SportGameFactory::create($type);
        return $item->showGameRule($game);   
    }

    /**
     * 檢查下注選項是否存在
     * @param string $type
     * @param SportGame $game
     * @param array $data
     * @return bool
     */
    public function checkGambleExist($type,SportGame $game,$data=[])
    {
        $item = SportGameFactory::create($type);
        return $item->checkGambleExist($game,$data);   
    }

    /**
     * 下注
     *
     * @param string $type
     * @param SportGame $game
     * @param array $data
     *
     * @return array
     */
    public function bet($type,SportGame $game,$data)
    {
        $item = SportGameFactory::create($type);

        //處理下注金額
        $amount_data = [
            '1' => (int)$data['virtual_cash_amount'],
            '2' => (int)$data['manage_amount'],
            '3' => (int)$data['share_amount'],
            '4' => (int)$data['interest_amount']
        ];
        return $item->bet($game,json_encode($amount_data),$data);   
    }

    /**
     * 取得單一賭盤下注狀況
     * @param string $type
     * @param SportGame $game
     * @param array $data
     *
     * @return array
     */
    public function getBetTotalByGamble($type,SportGame $game,$gamble)
    {
        $item = SportGameFactory::create($type);
        return $this->betRecordRepository->getBetTotalByGamble($item->getTable(),$game->id,$gamble);
    }

    /**
     * 取得下注格式
     *
     * @param string $type
     * @param int $game_id
     * @param array $data
     *
     * @return array
     */
    public function getFormatBetData($type,$game_id,$amount_data,$data)
    {
        $item = SportGameFactory::create($type);
        return $item->getFormatBetData($game_id,$amount_data,$data);   
    }

    /**
     * 取得下注狀況
     *
     * @param string $type
     * @param int $game_id
     * @param array $data
     *
     * @return array
     */
    public function getGambles($type,$game)
    {
        $item = SportGameFactory::create($type);
        return $item->getGambles($game);   
    }


    
    
  
}
