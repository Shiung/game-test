<?php
namespace App\Services\Statistic;

use App;
use App\Services\System\AdminActivityService;
use Illuminate\Support\Facades\DB;
use Exception;
use Auth;
use Session;

class RevenueService {
    
  
    protected $adminLog;
    /**
     * RevenueService constructor.
     *
     * @param AdminActivityService $adminLog
     */
    public function __construct(
        AdminActivityService $adminLog
    ) {
        $this->adminLog = $adminLog;
    }

    /**
     * 取得總和統計資料
     * @param date $start
     * @param date $end
     * @param int $statistic_type
     * @param string $period_type
     * @return collection
     */
    public function getStatByRange($start,$end,$statistic_type,$period_type = 'd')
    {
        $token = Session::get('a_token');
        try{
            $data = [
                'start_date' => $start,
                'end_date' => formatEndDate($end),
                'type' => $statistic_type,
                'period_type' => $period_type
            ];
            $data['token'] = $token;
            $result = curlApi(env('API_URL').'/stat/stat_date',$data); 
        } catch (Exception $e){

         return ['status' => false, 'error_code'=> 'EXCEPTION_ERROR','error_msg' => $e->getMessage()];
        }

        $result = json_decode($result, true);
        if($result['result'] == 1){
            return ['status' => true ,  'datas' => $result['detail'] ];
        } else {
            return ['status' => false, 'error_code' => $result['error_code'], 'error_msg' => $result['error_msg'],'detail' => $result['detail']];
        }
    }

    /**
     * 取得會員統計資料
     * @param date $start
     * @param date $end
     * @param int $statistic_type
     * @return array
     */
    public function getMemberStatByRange($start,$end,$statistic_type)
    {
        $token = Session::get('a_token');
        try{
            $data = [
                'start_date' => $start,
                'end_date' => formatEndDate($end),
                'type' => $statistic_type
            ];
            $data['token'] = $token;
            $result = curlApi(env('API_URL').'/stat/stat_member',$data); 
        } catch (Exception $e){

         return ['status' => false, 'error_code'=> 'EXCEPTION_ERROR','error_msg' => $e->getMessage()];
        }

        $result = json_decode($result, true);
        if($result['result'] == 1){
            return ['status' => true ,  'datas' => $result['detail'] ];
        } else {
            return ['status' => false, 'error_code' => $result['error_code'], 'error_msg' => $result['error_msg'],'detail' => $result['detail']];
        }
    }

   
  
}
