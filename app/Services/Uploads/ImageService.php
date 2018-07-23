<?php
namespace App\Services\Uploads;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use Illuminate\Http\Request;

class ImageService {
    
    protected $folder;
    protected $uploaddir;
    protected $extension;
    protected $original_filename;
    protected $new_filename;
    
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
     * 設定資料夾
     *
     * @param string $folder
     */
    public function setFolder($folder) 
    {
        $this->folder = $folder;
    }

    /**
     * 重新命名
     */
    public function renameFile() 
    {
        $timestamp = date('Y-m-d-H-i-s');
        $this->new_filename =  $timestamp .'.'. $this->extension;
    }



    /**
     * 上傳
     *
     * @param Request $request
     * @return string
     */
    public function upload(Request $request) 
    {
        if ($request->hasFile('file')) {

            $file = $request->file('file');

            //副檔名
            $this->extension = $file->getClientOriginalExtension();  

            //純檔名
            $this->original_filename = $file->getClientOriginalName();
            
            //重新命名
            $this->renameFile();

            //儲存
            $result = $file->move($this->uploaddir.$this->folder.'/', $this->new_filename);
            if ($result) {
                return json_encode(array('result' => 1, 'path' => $this->folder .'/'. $this->new_filename, 'filename' =>  $this->original_filename));
            } else {
                return json_encode(array('result' => 0));
            }

            
        } else {
            return json_encode(array('result' => 0, 'filename' => $this->folder .'/'. $this->original_filename));
        } 
    }

    /**
     * 刪除檔案
     * @return bool
     */
    public function delete($filename) 
    {
        $path = $this->uploaddir.$filename;
        if (file_exists($path)) {
            unlink($path);
        } 

        return true;
    }


    
}
