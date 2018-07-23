<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;
use Auth;

class FileController extends Controller
{
    /**
     * 參數設定
     *
     * @var string
     */
    protected $success_message = '操作成功';
    protected $failed_message = '操作失敗';
    protected $fileService;
    protected $page_title = '資訊分享';

    /**
     * 開頭宣告
     *
     * @return void
     */
    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }
    
    
    /**
     * 取得檔案
     * @param $filename
     * @return index view
     */
    public function index(Request $request)
    {
        $filename =  $request->get('name');
        if($filename) {
            return $this->fileService->downloadFile($filename);
        } else {
            abort(404);
        }

    }
   
}
