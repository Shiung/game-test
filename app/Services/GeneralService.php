<?php
namespace App\Services;

use App;

class GeneralService {

    /**
     * 初始化
     *
     * @param Account $account
     */
    public function __construct( ){

    }

    /**
     * 取得+一天的結束日期字串(順便過濾)
     * @param date $end
     * @return string
     */
    public function getFormatEndDate($end)
    {
        if ($end != 0) {
            $end = date("Y-m-d", strtotime($end ." +1 day"));
            return $end;  
        } 
            
    }

    

}