<?php
namespace App\Services;

use App;
use Storage;
use File;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Response as FacadeResponse;

class FileService {

    /**
     * 初始化
     *
     * @param Account $account
     */
    public function __construct( ){

    }
    
    /**
     * 處理檔案名稱
     * @param $filename
     * @return string
     */
    public function processFilename($filename)
    {
        return substr($filename,1,strlen($filename));         
    }
    
    /**
     * 檢查檔案是否存在
     * @param $filename
     * @return bool
     */
    public function checkFileExist($filename)
    {
        if(Storage::disk('public')->exists($this->processFilename($filename))){
            return true;
        } else {
            return false;
        }        
    }

    /**
     * 檢查檔案格式
     * @param $filename,array $types
     * @return bool
     */
    public function checkFileType($filename,$types)
    {
        $path = env('UPLOAD_PATH').$filename;
        $path_info = pathinfo($path);
        if(in_array($path_info['extension'],$types )) {
            return true;
        } else {
            return false;
        }
            
    }
    
    /**
     * 下載檔案
     * @param $filename
     * @return bool
     */
    public function downloadFile($filename)
    {
        $path =  storage_path('app/public/manager/'.$filename);

        if (!Storage::disk('file-upload')->exists($filename)) {
            abort(404);
        } else {
            $file = File::get($path);
            $response = FacadeResponse::make($file, 200);
          
            return response()->download($path);
        }
     
    }

    

}