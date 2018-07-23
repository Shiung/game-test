<?php
namespace App\Services\Uploads;

use Lang;
use App;
use App\Http\Requests;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;
use Auth;

class UploadService {
    

    /**
     * 開頭宣告
     *
     * @return void
     */
 
    public function __construct()
    {
     
    }
    
    /**
     * 上傳會員檔案
     * @return string 
     */
    public function uploadMemberFile() 
    {
        if (Input::hasFile('file')) {
            $file = Input::file('file');
            $folder =  '/member/'.Auth::guard('web')->user()->id;
            
            $timestamp = str_replace([' ', ':'], '-', \Carbon\Carbon::now()->toDateTimeString());
            $extension = $file->getClientOriginalExtension();  

            //取得純檔名（不含副檔名）
            $filename=$file->getClientOriginalName();
            $str_sec = explode(".",$filename);

            $name= $str_sec[0]. '-' .$timestamp .'.'. $extension;

            $file->move(storage_path().$folder.'/', $name);
            return json_encode(array('result' => 1, 'path' => $folder .'/'. $name, 'filename' =>  $name));
        } else {
            return json_encode(array('result' => 0, 'filename' => $folder .'/'. $name));
        }      
    }


    
}
