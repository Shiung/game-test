<?php
namespace App\Services\Game\Sport;

use App;
use App\Services\Game\Sport\SportService;
use App\Services\Game\Sport\SportGameService;
use App\Repositories\Game\SportRepository;
use App\Repositories\Game\CategoryRepository;
use App\Services\System\AdminActivityService;
use Illuminate\Support\Facades\DB;
use Exception;
use Session;

class Lottery539Service extends SportService{
    
    protected $sportRepository;
    protected $categoryRepository;
    protected $adminLog;
    
    /**
     * Lottery539Service constructor.
     *
     * @param AdminActivityService $log,
     * @param SportRepository $sportRepository
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
        parent::__construct($adminLog,$sportRepository,$categoryRepository,$sportGameService);
    }

   
    /**
     *  取得所有資料
     * @param int $category_id
     * @param array $status
     * @param date $start
     * @param date $end
     * @return array 
     */
    public function allByStatus($category_id,$status,$start = null,$end = null)
    {
        if($start == null && $end == null){
            $datas =  $this->sportRepository->all($category_id,['Scheduled','InProgress','Final']);
        } else {
            $datas =  $this->sportRepository->all($category_id,['Scheduled','InProgress','Final'],$start,formatEndDate($end));
        
        }
        $arr = [];
        if($status == 1){
            foreach ($datas as $data) {
                if(count($data->teams) > 0){
                    array_push($arr,$data);
                }
            }
        } else {
            foreach ($datas as $data) {
                if(count($data->teams) == 0){
                    array_push($arr,$data);
                }
            }
        }
        return $arr;
        
    }

    /**
     * 更新
     * @param array $data
     * @return array
     */
    public function update($data)
    {
        try{
            $send_data = [
               'number' => $data['number'], 
               'sport_id' => $data['sport_id'], 
               'result' => $data['result'], 
            ];
            $send_data['token'] = Session::get('a_token');
            
            $result = curlApi(env('API_URL').'/sport/modify_game_539',$send_data); 
        } catch (Exception $e){
         return ['status' => false, 'error_code' =>'System Error', 'error_msg'=> $e->getMessage()];
        }
        $result = json_decode($result, true);
        if($result['result'] == 1){
            return ['status' => true];
        } else {
            return ['status' => false, 'error_code' => $result['error_code'], 'error_msg' => $result['error_msg'],'content'=>$result['detail']];
        }
    }

    /**
     * 檢查下注/開獎號碼是否符合規則
     * @param array $numbers
     * @return bool
     */
    public function checkIfNumbersValid($numbers)
    {
        return checkNumbersRangeValid($numbers,1,39);
    }
    
  
}
