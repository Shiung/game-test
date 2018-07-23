<?php
namespace App\Services\Game\Sport;

use App;
use App\Repositories\Game\SportRepository;
use App\Repositories\Game\CategoryRepository;
use App\Services\System\AdminActivityService;
use App\Services\Game\Sport\SportGameService;
use Illuminate\Support\Facades\DB;
use Exception;
use Session;

class SportService {
    
    protected $sportRepository;
    protected $categoryRepository;
    protected $sportGameService;
    protected $adminLog;
    protected $type = '';
    protected $feature_name = '賽程';
    
    /**
     * SportService constructor.
     *
     * @param AdminActivityService $log,
     * @param SportRepository $sportRepository,
     * @param CategoryRepository $categoryRepository
     * @param SportGameService $sportGameService
     */
    public function __construct(
        AdminActivityService $adminLog,
        SportRepository $sportRepository,
        CategoryRepository $categoryRepository,
        SportGameService $sportGameService
    ) {
        $this->adminLog = $adminLog;
        $this->sportRepository = $sportRepository;
        $this->categoryRepository = $categoryRepository;
        $this->sportGameService = $sportGameService;
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
     *  類型
     *  ================
     */

     /**
     * 依照id查詢類別
     * @param int $id
     * @return collection
     */
    public function findCategory($id)
    {
        return $this->categoryRepository->find($id);
    }

    /**
     *  ================
     *  競賽
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
    public function all($category_id,$status,$start = null,$end = null)
    {
        if($start == null && $end == null){
            return $this->sportRepository->all($category_id,$status);
        } else {
            return $this->sportRepository->all($category_id,$status,$start,formatEndDate($end));
        
        }
        
    }
    

    /**
     * 依照id查詢資料
     * @param int $id
     * @return collection
     */
    public function find($id)
    {
        return $this->sportRepository->find($id);
    }

    /**
     * 更新
     * @param array $data
     * @return array
     */
    public function update($data)
    {
        DB::beginTransaction();
        try{
            $data['token'] = Session::get('a_token');
            $data['type'] = 'modify';
            $result = curlApi(env('API_URL').'/sport/store_sport',$data); 
        } catch (Exception $e){
         DB::rollBack();
         return ['status' => false, 'error'=> $e->getMessage()];
        }
        DB::commit();
        $result = json_decode($result, true);
        if($result['result'] == 1){
            return ['status' => true];
        } else {
            return ['status' => false, 'error_code' => $result['error_code'], 'error_msg' => $result['error_msg']];
        }
    }

    /**
     * 更新比分
     * @param array $data
     * @return array
     */
    public function updateScore($data)
    {
        DB::beginTransaction();
        try{
            $data['token'] = Session::get('a_token');
  
            $result = curlApi(env('API_URL').'/sport/update_score',$data); 
        } catch (Exception $e){
         DB::rollBack();
         return ['status' => false, 'error'=> $e->getMessage()];
        }
        DB::commit();
        $result = json_decode($result, true);
        if($result['result'] == 1){
            return ['status' => true];
        } else {
            return ['status' => false, 'error_code' => $result['error_code'], 'error_msg' => $result['error_msg']];
        }
    }

    /**
     * 更新賽程狀態
     * @param array $data
     * @return array
     */
    public function updateStatus($data)
    {
        DB::beginTransaction();
        try{
            $sport = $this->find($data['sport_id']);
            $sport->update([
                'status' => $data['status']
            ]);
            //新增log
            $this->adminLog->add([ 'content' =>  '更新：'.$data['sport_id'] ,'type' => '賽程']); 
        } catch (Exception $e){
         DB::rollBack();
         return ['status' => false, 'error'=> $e->getMessage()];
        }
        DB::commit();
        return ['status' => true];

    }


    /**
     * 新增
     * @param array $data
     * @return array
     */
    public function add($data)
    {   
        DB::beginTransaction();
        try{
            $data['token'] = Session::get('a_token');
            $data['type'] = 'add';
            $result = curlApi(env('API_URL').'/sport/store_sport',$data); 
        } catch (Exception $e){
         DB::rollBack();
         return ['status' => false, 'error'=> $e->getMessage()];
        }
        DB::commit();
        $result = json_decode($result, true);
        if($result['result'] == 1){
            return ['status' => true];
        } else {
            return ['status' => false, 'error_code' => $result['error_code'], 'error_msg' => $result['error_msg']];
        }
        
    }
    
    /**
     * 刪除
     * @param int $id
     * @return array
     */
    public function delete($id)
    {
        DB::beginTransaction();
        try{
            $data['token'] = Session::get('a_token');
            $data['sport_id'] = $id;
            $result = curlApi(env('API_URL').'/sport/delete_sport',$data); 
        } catch (Exception $e){
         DB::rollBack();
         return ['status' => false, 'error'=> $e->getMessage()];
        }
        DB::commit();
        $result = json_decode($result, true);
        if($result['result'] == 1){
            return ['status' => true];
        } else {
            return ['status' => false, 'error_code' => $result['error_code'], 'error_msg' => $result['error_msg']];
        }
    }

    /**
     * 取得最新賽程賭盤完整資料（for前台）
     * @param string $type
     * @return array 
     */
    public function getCompleteGames($type)
    {
        $category_arr = [];
        $categories = $this->categoryRepository->allByType($type);
        foreach ($categories as $category) {
            
            $sport_arr = [];
            foreach ($category->sports as $sport) {
                if($sport->status == 'Scheduled' || $sport->status == 'InProgress'){
                    
                    $games = $sport->games;
                    if(count($games)>0){
                        //檢查是否有開放下注的盤
                        if($games->where('bet_status','1')->count()>0 ){
                            //隊伍
                            $teams = $sport->teams;
                            $home_team = $teams->where('home','1')->first();
                            $away_team = $teams->where('home','0')->first();

                            
                            $data['start_datetime'] = $sport->start_datetime; 
                            $data['status'] = $sport->status; 
                            $data['taiwan_datetime'] = date('m-d H:i', strtotime($sport->taiwan_datetime)); 
                            $data['id'] = $sport->id; 
                            $data['bet_games'] = $games->where('bet_status','1')->count();
                            //隊伍資訊
                            $data['teams'] = [
                                'home' => [
                                    'id' => $home_team->id,
                                    'name' => $home_team->name,
                                    'score' => $home_team->score,
                                ],
                                'away' => [
                                    'id' => $away_team->id,
                                    'name' => $away_team->name,
                                    'score' => $away_team->score,
                                ]
                            ];
                            $data['sport'] = $sport;
                            $game_arr = [];
                            foreach ($games as $game) {
                                if($game->bet_status == '1'){
                                    $game_arr[$game->type] = $this->sportGameService->getGameParameter($game->type,$game,$sport,$teams);
                                }
                            }
                            $data['games'] = $game_arr;
                            array_push($sport_arr,$data);
                        }
                    }
                }


            }
            $category_arr[$category->name]['id'] = $category->id;
            $category_arr[$category->name]['sports'] = $sport_arr;
        }
    
        return $category_arr;
    }
    
    
    /**
     * 取得歷史賽程賭盤完整資料（for前台）
     * @param string $type
     * @param date $start
     * @param date $end
     * @return array
     */
    public function getHistoryGames($type,$start,$end)
    {
        $category_arr = [];
        $categories = $this->categoryRepository->allByType($type);
        foreach ($categories as $category) {
            
            $sport_arr = [];
            $sports = $this->sportRepository->getHistorySportsByType($category->id,['Final','Suspended','Postponed','Canceled','Processing'],$start,formatEndDate($end));
            foreach ($sports as $sport) {
 
                //隊伍
                $teams = $sport->teams;
                $home_team = $teams->where('home','1')->first();
                $away_team = $teams->where('home','0')->first();

                
                $data['start_datetime'] = $sport->start_datetime; 
                $data['taiwan_datetime'] = date('m-d H:i', strtotime($sport->taiwan_datetime)); 
                $data['status'] = $sport->status; 
                $data['id'] = $sport->id; 
                //隊伍資訊
                $data['teams'] = [
                    'home' => [
                        'id' => $home_team->id,
                        'name' => $home_team->name,
                        'score' => $home_team->score,
                    ],
                    'away' => [
                        'id' => $away_team->id,
                        'name' => $away_team->name,
                        'score' => $away_team->score,
                    ]
                ];
                array_push($sport_arr,$data);
                
                

            }
            $category_arr[$category->name]['id'] = $category->id;
            $category_arr[$category->name]['sports'] = $sport_arr;
        }
    
        return $category_arr;
    }
    
    /**
     * 檢查是否有人下注過該賽程的賭盤
     * @param Sport $sport
     * @return bool
     */
    public function checkIfHasBetRecords($sport)
    {
        $games = $sport->games;
        foreach ($games as $game) {
            $bets = $game->bets;
            if(count($game->bets)>0)
               return true;
        }
        return false;
        
    }
  
}
