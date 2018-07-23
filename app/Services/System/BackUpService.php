<?php
namespace App\Services;

use App;
use Storage;
use App\Models\Backup;
use App\Services\LogService;

class BackUpService {
    
    protected $logService;
    /**
     * 開頭宣告
     *
     * @return void
     */
    public function __construct(LogService $logService) {
        $this->logService =  $logService;
    }

    /**
     * 刪除備份
     *
     * @param $date(特定日期) 
     */
    public function deleteBackUpFiles($date)
    {
        //寫進log
        $this->logService->appendCronLog('Call Backup Cron :deleteBackUpFiles');

        $bks = BackUp::where('type','=',0)->where('created_at','<',$date)->get();
        foreach ($bks as $bk) {
            
            //刪除記錄
            $bk->delete();

            //刪除檔案
            Storage::disk('local')->delete($bk->filename);         
            
        }
    }

    /**
     * 自動備份
     *
     * @param $type (1:手動   0:自動)
     */
    public function db_backup($type = 0){

        //自動排程的話，寫進log
        if($type == 0) {
            $this->logService->appendCronLog('Call Backup Cron :Auto DB backup');
        }
        
        $time = time();
        $datetime = date('Y-m-d H:i:s',$time);
        if($type==0)
            $sqlfilename = "auto_".$time.".sql";
        else
            $sqlfilename = "manual_".$time.".sql";
        $cmd = "mysqldump -ubeta -p'ilovebeta!@#' beta  > /home/rfhs-group/beta/ds_test/storage/app/".$sqlfilename;
        exec($cmd);
        $data = array("filename"=>$sqlfilename, "type"=>$type, "created_at"=>$datetime);
        $result = Backup::create($data);
        if (!$result)
            throw new Exception ("error");
        else
            return $r=array("result" => 1);
    }


}
