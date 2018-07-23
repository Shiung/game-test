<?php
namespace App\Services\Uploads;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use Illuminate\Http\Request;

class ImageService {
    
    protected $folder;
    protected $uploaddir;
    
    /**
     * 開頭宣告
     *
     * @return void
     */
 
    public function __construct()
    {
        $this->uploaddir = env('UPLOAD_PATH');   
    }
    
    /**
     * 上傳
     *
     * @return string
     */
    public function upload() 
    {
        if (Input::hasFile('image')) {

            $file = Input::file('image');
            $folder = Input::get('folder');
            
            $timestamp = str_replace([' ', ':'], '-', \Carbon\Carbon::now()->toDateTimeString());
            $extension = $file->getClientOriginalExtension();  

            //取得純檔名（不含副檔名）
            $filename=$file->getClientOriginalName();
            $str_sec = explode(".",$filename);

            $name= $str_sec[0]. '-' .$timestamp .'.'. $extension;

            $file->move(env('UPLOAD_PATH').$folder.'/', $name);
            return json_encode(array('result' => 1, 'path' => $folder .'/'. $name, 'filename' =>  $name));
        } else {
            return json_encode(array('result' => 0, 'filename' => $folder .'/'. $name));
        } 
    }


    
}
