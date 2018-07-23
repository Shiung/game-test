<?php
namespace App\Services;

use App;
use Storage;
use File;

class LogService {
    
    /**
     * 開頭宣告
     *
     * @return void
     */
    public function __construct() {

    }

    /**
     * 新增排程log
     *
     * @param $text 
     */
    public function appendCronLog($text)
    {
        $today = date('Y-m-d');

        // 檔案紀錄在 storage/test.log
        $log_file_path = storage_path('cron/'.$today.'.log');

        // 記錄當時的時間
        $log_info = [
            'date'=>date('Y-m-d H:i:s').'-'.$text
        ];

        // 記錄 JSON 字串
        $log_info_json = json_encode($log_info) . "\r\n";

        // 記錄 Log
        File::append($log_file_path, $log_info_json);
    }

    /**
     * 刪除排程log
     *
     * @param $days(幾天) 
     */
    public function deleteLog($days)
    {
        $today = date('Y-m-d');
        $start = date("Y-m-d", strtotime($today ." -".$days." days"));
        //刪除檔案
        Storage::disk('cron')->delete($start.'.log');      
    }


    


}
